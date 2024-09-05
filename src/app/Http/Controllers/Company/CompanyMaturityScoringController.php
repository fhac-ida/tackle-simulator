<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Profil;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class CompanyMaturityScoringController extends Controller
{
    /**
     * Calculates the maximum value for each corresponding element from two vectors.
     * Vectors are given as strings in the format "(1,2,3,2,3)"
     *
     * @param $v1
     * @param $v2
     * @return string
     */
    private function calcMaxMaturityVector($v1, $v2) //Returns a vector with maximized entries from two vectors. All vectors are strings like "(1,2,3,2,3)".
    {
        $v1 = explode(',', $v1); //Convert to array
        $v2 = explode(',', $v2);

        $v = []; // Initialize an empty array for the result
        $length = min(count($v1), count($v2)); // Get the minimum length of the two vectors
        for ($i = 0; $i < $length; $i++) {
            $v[] = max($v1[$i], $v2[$i]); // Store the maximum value for each corresponding element
        }
        //Transcribe leftover values to the new vector for v1 and v2 of unequal length
        for ($i = 0; $i < count($v1) - $length; $i++) {
            $v[] = $v1[$i];
        }
        for ($i = 0; $i < count($v2) - $length; $i++) {
            $v[] = $v2[$i];
        }

        return implode(',', $v);
    }

    /**
     * Retrieves all answers for a given category ID related to the provided company profile
     *
     * @param $companyProfile
     * @param $categoryId
     * @return array
     */
    private function getCategoryAnswers($companyProfile, $categoryId)
    {
        $answers = []; //Collect all answers of category ID for the current company profile
        $anweredQuestions = $companyProfile->answeredQuestions()->wherehas('category', function ($query) use ($categoryId) {
            $query->where('category_id', $categoryId);
        })->get();
        // Iterate through the answered questions and store relevant answers in the $answers array
        foreach ($anweredQuestions as $pivot) {
            if ($pivot->pivot->profile_id == $companyProfile->profile_id && $pivot->pivot->question_id != 27) { // No baseline on incident recovery (question 27) -> skip for now
                $answers[$pivot->pivot->question_id] = $pivot->pivot->answer_id;
            }
        }

        return $answers;
    }

    /**
     * Calculates the baseline maturity vector for a given company profile
     *
     * @param $companyProfile
     * @return array
     */
    private function calcCompanyBaseline($companyProfile)
    {
        $answers = $this->getCategoryAnswers($companyProfile, 1);

        if (count($answers) < 4) {
            return [];
        }

        // Load the baseline data from a JSON file, abort if the file does not exist
        if (Storage::exists('companyBaseline.json')) {
            $baseline = json_decode(Storage::get('companyBaseline.json'));
        } else {
            abort(404); // Abbruch wenn Datei nicht existiert.
        }

        // Define domains, sizes, and sectors
        $domains = ['networkSecurity', 'deviceConnectivity', 'plcHmi', 'dataSecurity', 'supplyChainSecurity'];
        $sizes = ['microManufacturers', 'smallManufacturers', 'mediumManufacturers'];
        $sectors = ['essential', 'important', 'nonImportant'];
        $size = $sizes[$answers[1] - 1];
        $sector = $sectors[$answers[2] - 4];

        $response = []; //To be returned

        // Iterate through each domain to calculate the baseline vector
        foreach ($domains as $domain) {
            if ($domain == 'dataSecurity') { //Uses different sectors: non-critical, critical, part of critical network, personal data
                $v2 = '0,0,0,0,0';
                if ($answers[2] == 5) { //Important => Manufacturer?
                    if ($answers[4] == 11) { //Personal data exchange
                        $v2 = $baseline->$domain->$size->personalData.','.$baseline->peopleAndCultures->$size->personalData;
                    }

                    $v1 = $baseline->$domain->$size->nonCritical.','.$baseline->peopleAndCultures->$size->nonCritical;
                } else {
                    if ($answers[4] == 11) { //Personal data exchange
                        $v2 = $baseline->$domain->sme->personalData.','.$baseline->peopleAndCultures->sme->personalData;
                    }

                    if ($answers[2] == 4) { //Essential => Critical
                        $v1 = $baseline->$domain->sme->critical.','.$baseline->peopleAndCultures->sme->critical;
                    } else {
                        $v1 = $baseline->$domain->sme->nonCritical.','.$baseline->peopleAndCultures->sme->nonCritical;
                    }
                }
                $vCompanySector = $this->calcMaxMaturityVector($v1, $v2); //In case personal data is exchanged, but company is also essential.
            } elseif ($domain == 'deviceConnectivity') {
                if ($answers[2] == 5) { //Important => Manufacturer?
                    $vCompanySector = $baseline->$domain->$size->$sector.','.$baseline->remoteAccess->$size->$sector;
                } else { //Non-manufacturing SME
                    $vCompanySector = $baseline->$domain->sme->$sector.','.$baseline->remoteAccess->sme->$sector;
                }
            } else {
                if ($answers[2] == 5) { //Important => Manufacturer?
                    $vCompanySector = $baseline->$domain->$size->$sector;
                } else { //Non-manufacturing SME
                    $vCompanySector = $baseline->$domain->sme->$sector;
                }
            }

            if ($answers[3] != 10) { //Direct services: Use sector of costumer and compare
                if ($domain == 'dataSecurity') { //Uses different sectors: non-critical, critical, part of critical network, personal data
                    $v2 = '0,0,0,0,0';
                    if ($answers[4] == 11) { //Personal data exchange
                        $v2 = $baseline->$domain->providers->personalData.','.$baseline->peopleAndCultures->providers->personalData;
                    }

                    if ($answers[3] == 7) { //Essential => Critical?
                        $v1 = $baseline->$domain->providers->critical.','.$baseline->peopleAndCultures->providers->critical;
                    } else {
                        $v1 = $baseline->$domain->providers->nonCritical.','.$baseline->peopleAndCultures->providers->nonCritical;
                    }

                    $vCustomerSector = $this->calcMaxMaturityVector($v1, $v2);
                } elseif ($domain == 'deviceConnectivity') {
                    switch ($answers[3]) {
                        case 7: //Essential
                            $vCustomerSector = $baseline->$domain->providers->essentialSupplyChain.','.$baseline->remoteAccess->providers->essentialSupplyChain;
                            break;
                        case 8: //Important
                            $vCustomerSector = $baseline->$domain->providers->important.','.$baseline->remoteAccess->providers->important;
                            break;
                        default: //Non-important
                            $vCustomerSector = $baseline->$domain->providers->nonImportant.','.$baseline->remoteAccess->providers->nonImportant;
                    }
                } else {
                    switch ($answers[3]) {
                        case 7: //Essential
                            $vCustomerSector = $baseline->$domain->providers->essentialSupplyChain;
                            break;
                        case 8: //Important
                            $vCustomerSector = $baseline->$domain->providers->important;
                            break;
                        default: //Non-important
                            $vCustomerSector = $baseline->$domain->providers->nonImportant;
                    }
                }
                //Convert notation per domain from String to array of integers
                $response[] = array_map(fn ($val) => intval($val), explode(',', $this->calcMaxMaturityVector($vCompanySector, $vCustomerSector))); //Check for maximum baseline, in case company is essential but customers aren't
            } else { //No direct services
                $response[] = array_map(fn ($val) => intval($val), explode(',', $vCompanySector));
            }
        }

        return $response;
    }

    /**
     * Calculates the maturity score for the company profile based on the answers given
     *
     * @param $companyProfile
     * @return array
     */
    private function calcMaturityScore($companyProfile)
    {
        // Get the total number of questions in category 1
        $numQuestionsCat1 = Question::where('category_id', 1)->count();
        // Get the maximum answer ID for the last question in category 1
        $numAnswersCat1 = Answer::where('question_id', $numQuestionsCat1)->orderBy('answer_id', 'desc')->first()->answer_id; //get last element

        $maturityScore = []; // Initialize an array for the maturity score

        // Iterate through categories 2 to 6 to calculate the maturity score for each
        for ($categoryId = 2; $categoryId <= 6; $categoryId++) {
            $answers = $this->getCategoryAnswers($companyProfile, $categoryId);
            $domainMaturityVector = []; // Initialize an array for the maturity vector of the domain

            if (count($answers) >= Question::where('category_id', $categoryId)->count() - ($categoryId == 6 ? 1 : 0)) { // Incidence response skipped for now, so subtract from number of questions for category 6
                foreach ($answers as $answer) {
                    $domainMaturityVector[] = ($answer - $numAnswersCat1 - 1) % 4; // There are 4 answers and 4 security levels (0-3) per control. So subtracting category 1, which doesn't follow this pattern, we get the security level, based on the current answer.
                }
            }
            $maturityScore[] = $domainMaturityVector; // Add the maturity vector to the score
        }

        return $maturityScore; // Return the maturity score
    }

    /**
     * Getter to get the baseline maturity vector for the company
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCompanyBaseline(Request $request)
    {
        $companyProfile = Profil::where('profile_id', $request->profile_id)->first(); // Retrieve the company profile

        // Check if the user has permission to access this profile
        if ($companyProfile['user_id'] != $request->user()->id) {
            return response()->json($companyProfile, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $response = $this->calcCompanyBaseline($companyProfile); // Calculate the baseline

        return response()->json($response, Response::HTTP_OK); // Return the baseline as a JSON response
    }

    /**
     * Getter to get the maturity score for the company
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMaturityScore(Request $request)
    {
        $companyProfile = Profil::where('profile_id', $request->profile_id)->first(); // Retrieve the company profile

        // Check if the user has permission to access this profile
        if ($companyProfile['user_id'] != $request->user()->id) {
            return response()->json($companyProfile, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        $maturityScore = $this->calcMaturityScore($companyProfile); // Calculate the maturity score

        return response()->json($maturityScore, Response::HTTP_OK); // Return the maturity score as a JSON response
    }

    /**
     * Getter to get recommendations for improving the company's maturity score
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRecommendation(Request $request)
    {
        $companyProfile = Profil::where('profile_id', $request->profile_id)->first(); // Retrieve the company profile

        // Check if the user has permission to access this profile
        if ($companyProfile['user_id'] != $request->user()->id) {
            return response()->json($companyProfile, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $baseline = $this->calcCompanyBaseline($companyProfile); // Calculate the baseline

        if ($baseline == []) { //Error handling
            return response()->json(['Please answer all profile questions first', '-', ''], Response::HTTP_OK);
        }

        $level = $this->calcMaturityScore($companyProfile); // Calculate the maturity score

        $recommendation = []; // Initialize an array for recommendations

        // Get the maximum answer ID for the last question in category 1
        $numQuestionsCat1 = Question::where('category_id', 1)->count();
        $priorAnswers = Answer::where('question_id', $numQuestionsCat1)->orderBy('answer_id', 'desc')->first()->answer_id + 1; //get last element

        // Iterate through each domain to generate recommendations
        for ($domain = 0; $domain < count($baseline); $domain++) {
            for ($control = 0; $control < count($baseline[$domain]); $control++) {
                if ($level[$domain] != [] && $level[$domain][$control] < $baseline[$domain][$control]) {
                    $ans = Answer::where('answer_id', $priorAnswers + $baseline[$domain][$control])->first();
                    if ($ans->question_id == 27) { // Incident recovery...
                        continue;
                    }
                    $answer = $ans->answer;
                    if ($answer[0] == '+') {
                        $answer = ucfirst(substr($answer, 2)); // Remove any leading '+' character our way to identify
                    }
                    $answer = '<ol><li>'.$answer.'</li>';
                    // Include additional steps if required
                    for ($i = 0; $level[$domain][$control] + $i + 1 < $baseline[$domain][$control] && Answer::where('answer_id', $priorAnswers + $baseline[$domain][$control] - $i)->first()->answer[0] == '+'; $i++) {
                        $answer2 = Answer::where('answer_id', $priorAnswers + $baseline[$domain][$control] - $i - 1)->first()->answer;
                        if ($answer2[0] == '+') {
                            $answer2 = ucfirst(substr($answer2, 2));
                        }
                        $answer .= '<li>'.$answer2.'</li>';
                    }
                    $answer .= '</ol>';
                    $recommendation[] = Question::where('question_id', $ans->question_id)->first()->question.':<br> '.$answer;
                }
                $priorAnswers += 4; // Move to the next set of answers
            }
        }

        return response()->json([$baseline, $level, $recommendation], Response::HTTP_OK);
    }
}
