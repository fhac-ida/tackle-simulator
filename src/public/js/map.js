//map.js

/**
 * Attach a submit event handler to the form with ID 'formSaveConnections'
 * Handles the submission of the SaveConnections form
 * function sends the form data to the specified URL using a POST request. If the request is successful, it hides the save button and displays a success message
 */
$('#formSaveConnections').on('submit', function(event)  {

    event.preventDefault(); // Prevents the default form submission

    const url = $(this).attr('data-action'); // Get the URL from the form's data-action attribute

    // Setup AJAX with CSRF token for security
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Perform an AJAX POST request to the specified URL
    $.ajax({
        url: url,
        type:'POST',
        data: new FormData( this ), // Serialize the form data to be sent
        processData: false, // Prevent jQuery from processing the data
        contentType: false, // Prevent jQuery from setting the content type
        dataType: 'JSON',
        //cache: false,
        timeout: 8000, // Set a timeout of 8 seconds
        beforeSend: function() {
            //Swal.showLoading();
        },
        success:function(response){
            $('#button_save_connections').hide(); //Hide the save button
            $('#div_save_connections').addClass( "d-none" ); // Hide the save connections div
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Ajax: '+response.success, // Show success message
                showConfirmButton: false,
                timer: 1500
            })
        },
        complete: function() {
            //Swal.hideLoading();
        },
        error: function(jqXHR, testStatus, error) { //error handling
            console.log(error); // Log the error to the console
            alert("Page cannot open. Error:" + error); // Alert the user of the error
            Swal.hideLoading(); // Hide the loading indicator
        },
    });

});

/**
 * Attach a submit event handler to the form with ID 'formSaveConnections'
 * Handles the submission of the SavePosition form
 * function sends the form data to the specified URL using a POST request, then handles succes and error response just like the function above
 */
$('#formSavePositions').on('submit', function(event)  {

    event.preventDefault(); // Prevents the default form submission

    const url = $(this).attr('data-action'); // Get the URL from the form's data-action attribute

    // Setup AJAX with CSRF token for security
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Perform an AJAX POST request to the specified URL
    $.ajax({
        url: url,
        type:'POST',
        data: new FormData( this ), // Serialize the form data to be sent
        processData: false, // Prevent jQuery from processing the data
        contentType: false, // Prevent jQuery from setting the content type
        dataType: 'JSON',
        timeout: 8000, // Set a timeout of 8 seconds
        beforeSend: function() {
            //Swal.showLoading();
        },
        success:function(response){
            $('#button_save_positions').hide(); // Hide the save button
            $('#div_save_positions').addClass('d-none'); // Hide the save positions div
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Ajax: '+response.success, // Show success message
                showConfirmButton: false,
                timer: 1500
            })
        },
        complete: function() {
            //Swal.hideLoading();
        },
        error: function(jqXHR, testStatus, error) { //error handling
            console.log(error); // Log the error to the console
            alert("Page cannot open. Error:" + error); // Alert the user of the error
            Swal.hideLoading(); // Hide the loading indicator
        },
    });

});


/**
 * Attach a click event handler to the element with ID 'mediumButton'
 * Sends an AJAX GET request to fetch content for a modal
 * Function sends a GET request to the URL specified in the data-attr attribute of the button
 * If the request is successful, it shows the modal and displays the fetched content in the modal body
 *
 * Display a modal (medium modal)
 */
$(document).on('click', '#mediumButton', function(event) {
    event.preventDefault(); // Prevent the default action

    let href = $(this).attr('data-attr'); // Get the URL from the data-attr attribute

    // Perform an AJAX GET request to the specified URL
    $.ajax({
        url: href,
        beforeSend: function() {
            //Swal.showLoading();
        },
        // return the result
        success: function(result) {
            $('#mediumModal').modal("show"); // Show the modal
            $('#mediumBody').html(result).show(); // Display the result in the modal body
        },
        complete: function() {
            //Swal.hideLoading();
        },
        error: function(jqXHR, testStatus, error) { //error handling
            console.log(error); // Log the error to the console
            alert("Page " + href + " cannot open. Error:" + error); // Alert the user of the error
            $('#loader').hide(); // Hide the loader
        },
        timeout: 8000 // Set timeout to 8 seconds
    })
});

/**
 * Handles updating the size of the canvas and the positions of map objects within the canvas
 * The updateCanvasSize function updates the values of form fields with the canvas's width and height
 * This function is called when the document is ready and whenever the window is resized
 * The .mapObject elements are iterated over, and their positions are adjusted based on the canvas size if their left distance is less than 2
 */
$( document ).ready(function() {
    const canvas = $( '#canvas' ); // Select the canvas element

    // Function to update the canvas size in the form fields
    function updateCanvasSize()  {
        $( '#mapobject_containerwidth' ).val(canvas.width()) ;
        $( '#mapobject_containerheight' ).val(canvas.height()) ;
    }

    // Update canvas size on window resize
    $(window).resize(function() {
        updateCanvasSize();
    });

    // Initial canvas size update
    updateCanvasSize();

    // Adjust the position of each map object
    $('.mapObject').each(function( index, obj ) {
        const moObj = $(obj);

        var leftDist = parseFloat(moObj.css('left').slice(0, -2) );
        var topDist = parseFloat(moObj.css('top').slice(0, -2) );

        if(leftDist < 2)  {
            leftDist *= canvas.width();
            topDist *= canvas.height();

            moObj.css('left', leftDist + "px");
            moObj.css('top', topDist + "px");
        }
    });


});
/**
 * Initializes a context menu on elements with the class mapObject
 * The $.contextMenu function is used to create a context menu with "Edit" and "Delete" options.
 * When an option is selected from the context menu,
 * an AJAX GET request is sent to either the edit or delete URL,
 * depending on the selected option.
 * If the request is successful, the modal is shown with the fetched content
 */
$(function() {
    // Initialize context menu on elements with class 'mapObject'
    $.contextMenu({
        selector: '.mapObject', // Apply to elements with class 'mapObject'
        callback: function(key, options) {
            const href_edit = $(this).attr('data-href-edit'); // Get the edit URL
            const href_delete = $(this).attr('data-href-delete'); // Get the delete URL

            let href = "#"; // Default URL

            if(key == "edit")  href = href_edit;
            else if(key == "delete")  href = href_delete;

            // Perform an AJAX GET request to the specified URL
            $.ajax({
                url: href,
                beforeSend: function() {
                    //Swal.showLoading();
                },
                // return the result
                success: function(result) {
                    $('#mediumModal').modal("show"); // Show the modal
                    $('#mediumBody').html(result).show(); // Display the result in the modal body
                },
                complete: function() {
                    //Swal.hideLoading();
                },
                error: function(jqXHR, testStatus, error) { //error handling
                    console.log(error); // Log the error to the console
                    alert("Page " + href + " cannot open. Error:" + error); // Alert the user of the error
                    $('#loader').hide(); // Hide the loader
                },
                timeout: 8000 // Set timeout to 8 seconds
            })
        },
        items: {
            "edit": {name: "Edit", icon: "edit"},
            "delete": {name: "Delete", icon: "delete"},
        }
    });
});
