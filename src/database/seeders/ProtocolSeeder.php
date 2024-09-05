<?php

namespace Database\Seeders;

use App\Models\Preview\InterfaceCategory;
use App\Models\Protocol;
use Illuminate\Database\Seeder;

class ProtocolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ethernetID = InterfaceCategory::where('name', 'Ethernet')->first()->id;
        $fieldbusID = InterfaceCategory::where('name', 'Fieldbus')->first()->id;
        $wirelessID = InterfaceCategory::where('name', 'Wireless')->first()->id;
        $otherID = InterfaceCategory::where('name', 'Other')->first()->id;

        $protocols = [
            //Industrial Ethernet
            ['name' => 'EtherNet/IP',
                'interfacecategory_id' => $ethernetID],
            ['name' => 'PROFINET',
                'interfacecategory_id' => $ethernetID],
            ['name' => 'EtherCAT',
                'interfacecategory_id' => $ethernetID],
            ['name' => 'TwinCAT',
                'interfacecategory_id' => $ethernetID],
            ['name' => 'POWERLINK',
                'interfacecategory_id' => $ethernetID],
            ['name' => 'CC-Link IE',
                'interfacecategory_id' => $ethernetID],
            ['name' => 'IO-Link',
                'interfacecategory_id' => $ethernetID],
            ['name' => 'Modbus TCP/IP',
                'interfacecategory_id' => $ethernetID],
            ['name' => 'SERCOS III',
                'interfacecategory_id' => $ethernetID],
            ['name' => 'DNP3',
                'interfacecategory_id' => $ethernetID],
            ['name' => 'S7COMM',
                'interfacecategory_id' => $ethernetID],
            ['name' => 'TCP ISO on TCP UDP (Open User Communication)',
                'interfacecategory_id' => $ethernetID],
            ['name' => 'ptp (Punkt-zu-Punkt Communication)',
                'interfacecategory_id' => $ethernetID],
            ['name' => 'MPI (Multi-Point-Interface-Protocol)',
                'interfacecategory_id' => $ethernetID],
            ['name' => 'Point-to-Point Communication)',
                'interfacecategory_id' => $ethernetID],
            ['name' => 'Simatic Net CP',
                'interfacecategory_id' => $ethernetID],
            ['name' => 'SNMP (Simple Network Management Protocol)',
                'interfacecategory_id' => $ethernetID],
            ['name' => 'Other Ethernet',
                'interfacecategory_id' => $ethernetID],
            ['name' => 'OPC UA',
                'interfacecategory_id' => $ethernetID],

            //Fieldbus
            ['name' => 'Interbus',
                'interfacecategory_id' => $fieldbusID],
            ['name' => 'Profibus DP',
                'interfacecategory_id' => $fieldbusID],
            ['name' => 'USS Communication (Universal Serial Interface Protocol)',
                'interfacecategory_id' => $fieldbusID],
            ['name' => 'CC-Link',
                'interfacecategory_id' => $fieldbusID],
            ['name' => 'Modbus-RTU',
                'interfacecategory_id' => $fieldbusID],
            ['name' => 'CANopen',
                'interfacecategory_id' => $fieldbusID],
            ['name' => 'DeviceNet',
                'interfacecategory_id' => $fieldbusID],
            ['name' => 'AS-Interface',
                'interfacecategory_id' => $fieldbusID],
            ['name' => 'Other Fieldbus',
                'interfacecategory_id' => $fieldbusID],

            // Wireless
            ['name' => 'Wlan',
                'interfacecategory_id' => $wirelessID],
            ['name' => 'LTE / 4G',
                'interfacecategory_id' => $wirelessID],
            ['name' => '5G',
                'interfacecategory_id' => $wirelessID],
            ['name' => 'GPRS',
                'interfacecategory_id' => $wirelessID],
            ['name' => 'Bluetooth',
                'interfacecategory_id' => $wirelessID],
            ['name' => 'Other wireless',
                'interfacecategory_id' => $wirelessID],

            //Other
            ['name' => 'gesichertes NTP',
                'interfacecategory_id' => $otherID],
            ['name' => 'SNMPv3',
                'interfacecategory_id' => $otherID],
            ['name' => 'FTPS',
                'interfacecategory_id' => $otherID],
            ['name' => 'HTTPS (Webserver)',
                'interfacecategory_id' => $otherID],
            ['name' => 'VPN',
                'interfacecategory_id' => $otherID],
            ['name' => 'IPv4',
                'interfacecategory_id' => $otherID],
            ['name' => 'IPv6',
                'interfacecategory_id' => $otherID],
            ['name' => 'Uhrzeitsynchronisation',
                'interfacecategory_id' => $otherID],
            ['name' => 'HMI -Kommunikation',
                'interfacecategory_id' => $otherID],

            ['name' => 'Other',
                'interfacecategory_id' => $otherID],

            //Ethernet Ergänzung
            ['name' => 'LLDP',
                'interfacecategory_id' => $ethernetID],
            ['name' => 'MRP',
                'interfacecategory_id' => $ethernetID],
            ['name' => 'PTCP',
                'interfacecategory_id' => $ethernetID],
            ['name' => 'TFTP',
                'interfacecategory_id' => $ethernetID],
            ['name' => 'Other Ethernet',
                'interfacecategory_id' => $ethernetID],

        ];

        Protocol::insert($protocols);
    }
}
