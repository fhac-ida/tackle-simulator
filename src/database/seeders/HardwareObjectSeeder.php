<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HardwareObjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $eId = DB::table('interface_categories')->insertGetId([
            'name' => 'Ethernet',
            'colorcode' => '#ff0000',
        ]);
        $fId = DB::table('interface_categories')->insertGetId([
            'name' => 'Fieldbus',
            'colorcode' => '#00ff00',
        ]);

        $uId = DB::table('interface_categories')->insertGetId([
            'name' => 'USB',
            'colorcode' => '#0000ff',
        ]);

        $oId = DB::table('interface_categories')->insertGetId([
            'name' => 'Other',
            'colorcode' => '#fbff00',
        ]);

        $wId = DB::table('interface_categories')->insertGetId([
            'name' => 'Wireless',
            'colorcode' => '#f500cc',
        ]);

        $pId = DB::table('interface_categories')->insertGetId([
            'name' => 'Programming',
            'colorcode' => '#00f2ff',
        ]);

        // PLC's

        //Siemens S7-1200
        $hardwareObjects[] = DB::table('hardware_objects')->insertGetId([
            'name' => 'S7-1200',
            'type' => 'PLC',
            'description' => '',
            'vendor' => 'Siemens',
            'einfuehrungsjahr' => 2009,
        ]);

        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[0],
            'interfacecategory_id' => $eId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[0],
            'interface_model_id' => $tempid,
            'maxConnections' => 1,
        ]);

        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 2, //PROFINET
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 8, //Modbus TCP/IP
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 12, //TCP ISO on TCP UDP
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 13, //ptp
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 15, //ptp
        ]);

        //------------------------------------------//

        //Siemens S7-1500
        $hardwareObjects[] = DB::table('hardware_objects')->insertGetId([
            'name' => 'S7-1500',
            'type' => 'PLC',
            'description' => '',
            'vendor' => 'Siemens',
            'einfuehrungsjahr' => 2012,

            'hasPassword' => true,
            'hasFirewall' => true,
            'hasEncryption' => true,
        ]);

        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[1],
            'interfacecategory_id' => $eId,
        ]);

        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[1],
            'interface_model_id' => $tempid,
            'maxConnections' => 4,
        ]);

        //Protokolle Ethernet
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 1, //ethernet/ip
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 2, //profinet
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 7, //iolink
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 8, //modbus tcp/ip
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 11, //s7comm
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 12, //tcp iso on tcp udp
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 15, //point to point
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 17, //snmp
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 19, //opc ua
        ]);

        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[1],
            'interfacecategory_id' => $fId,
        ]);

        //Protokolle Fieldbus
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 21, //Profibus dp
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 22, //uss communication
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 24, //modbus-rtu
        ]);

        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[1],
            'interface_model_id' => $tempid,
            'maxConnections' => 2,
        ]);

        //Schneider Modicon M241
        $hardwareObjects[] = DB::table('hardware_objects')->insertGetId([
            'name' => 'Modicon M241',
            'type' => 'PLC',
            'description' => '',
            'vendor' => 'Schneider',
            'einfuehrungsjahr' => 2014,
        ]);

        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[2],
            'interfacecategory_id' => $uId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[2],
            'interface_model_id' => $tempid,
            'maxConnections' => 1,
        ]);

        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[2],
            'interfacecategory_id' => $fId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[2],
            'interface_model_id' => $tempid,
            'maxConnections' => 1,
        ]);

        //Protokolle Fieldbus

        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 25, //canopen
        ]);

        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[2],
            'interfacecategory_id' => $eId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[2],
            'interface_model_id' => $tempid,
            'maxConnections' => 1,
        ]);

        //Protokolle Ethernet
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 8, //modbus tcp/ip
        ]);

        //------------------------------------------//

        //Schneider Modicon M262
        $hardwareObjects[] = DB::table('hardware_objects')->insertGetId([
            'name' => 'Modicon M262',
            'type' => 'PLC',
            'description' => '',
            'vendor' => 'Schneider',
            'einfuehrungsjahr' => 2020,
        ]);

        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[3],
            'interfacecategory_id' => $eId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[3],
            'interface_model_id' => $tempid,
            'maxConnections' => 3,
        ]);

        //Protokolle Ethernet
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 8, //modbus tcp/ip
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 9, //sercos III
        ]);

        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[3],
            'interfacecategory_id' => $fId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[3],
            'interface_model_id' => $tempid,
            'maxConnections' => 1,
        ]);

        //Protokolle Fieldbus
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 25, //canopen
        ]);

        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[3],
            'interfacecategory_id' => $uId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[3],
            'interface_model_id' => $tempid,
            'maxConnections' => 1,
        ]);

        //------------------------------------------//

        //Compactlogix 5380
        $hardwareObjects[] = DB::table('hardware_objects')->insertGetId([
            'name' => 'Compactlogix 5380',
            'type' => 'PLC',
            'description' => '',
            'vendor' => 'Allen-Bradley',
            'einfuehrungsjahr' => 2020,
        ]);

        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[4],
            'interfacecategory_id' => $uId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[4],
            'interface_model_id' => $tempid,
            'maxConnections' => 1,
        ]);

        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[4],
            'interfacecategory_id' => $eId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[4],
            'interface_model_id' => $tempid,
            'maxConnections' => 2,
        ]);

        //Protokolle Ethernet
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 1, //ethernet/ip
        ]);

        //------------------------------------------//

        //ILC 390 PN 2TX-IB
        $hardwareObjects[] = DB::table('hardware_objects')->insertGetId([
            'name' => 'ILC 390 PN 2TX-IB',
            'type' => 'PLC',
            'description' => '',
            'vendor' => 'Phoenix Contact',
        ]);

        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[5],
            'interfacecategory_id' => $eId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[5],
            'interface_model_id' => $tempid,
            'maxConnections' => 2,
        ]);

        //Protokolle Ethernet
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 2, //Profinet
        ]);

        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[5],
            'interfacecategory_id' => $fId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[5],
            'interface_model_id' => $tempid,
            'maxConnections' => 4,
        ]);

        //Protokolle Fieldbus
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 20, //interbus
        ]);

        //------------------------------------------//

        //PC Next AXC F 2152
        $hardwareObjects[] = DB::table('hardware_objects')->insertGetId([
            'name' => 'Next AXC F 2152',
            'type' => 'PLC',
            'description' => '',
            'vendor' => 'Phoenix Contact',
        ]);

        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[6],
            'interfacecategory_id' => $fId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[6],
            'interface_model_id' => $tempid,
            'maxConnections' => 1,
        ]);

        //Protokolle Fieldbus

        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[6],
            'interfacecategory_id' => $eId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[6],
            'interface_model_id' => $tempid,
            'maxConnections' => 2,
        ]);

        //Protokolle Ethernet
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 2, //Profinet
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 7, //IOLink
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 18, //Other Ethernet
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 19, //OPC UA
        ]);

        //------------------------------------------//

        //Mitsuishi Electric FX5u-32M
        $hardwareObjects[] = DB::table('hardware_objects')->insertGetId([
            'name' => 'FX5U-32M',
            'type' => 'PLC',
            'description' => '',
            'vendor' => 'Mitsubishi Electric',
        ]);

        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[7],
            'interfacecategory_id' => $eId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[7],
            'interface_model_id' => $tempid,
            'maxConnections' => 8,
        ]);

        //Ethernet Protokolle
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 6, //cc-link ie
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 8, //modbus tcp/ip
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 18, //other ethernet
        ]);

        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[7],
            'interfacecategory_id' => $fId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[7],
            'interface_model_id' => $tempid,
            'maxConnections' => 8,
        ]);

        //Fieldbus Protokolle
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 23, //cc-link
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 24, //Modbus RTU
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 28, //Other Fieldbus
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 44, //Other
        ]);

        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[7],
            'interfacecategory_id' => $uId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[7],
            'interface_model_id' => $tempid,
            'maxConnections' => 1,
        ]);

        //------------------------------------------//

        //Beckhoff CX9020
        $hardwareObjects[] = DB::table('hardware_objects')->insertGetId([
            'name' => 'CX9020',
            'type' => 'PLC',
            'description' => '',
            'vendor' => 'Beckhoff',
        ]);

        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[8],
            'interfacecategory_id' => $uId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[8],
            'interface_model_id' => $tempid,
            'maxConnections' => 4,
        ]);

        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[8],
            'interfacecategory_id' => $eId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[8],
            'interface_model_id' => $tempid,
            'maxConnections' => 2,
        ]);

        //Protokolle Ethernet
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 2, //Profinet
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 3, //Ethercat
        ]);

        //Fieldbus wäre über zusatzmodule möglich, deshalb nicht drin

        //------------------------------------------//

        //BUSKOPPLER
        //PC IL PN BK DI8 D04 2TX-PAC
        $hardwareObjects[] = DB::table('hardware_objects')->insertGetId([
            'name' => 'IL PN BK DI8 DO4 2TX-PAC',
            'type' => 'Buskoppler',
            'description' => '',
            'vendor' => 'Phoenix Contact',
        ]);

        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[9],
            'interfacecategory_id' => $eId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[9],
            'interface_model_id' => $tempid,
            'maxConnections' => 2,
        ]);

        //Protokolle Ethernet
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 2, //Profinet
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 1, //Ethernet/ip
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 45, //lldp
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 17, //snmp
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 46, //mrp
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 47, //ptcp
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 48, //tftp
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 49, //other ethernet
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 40, //IPV4
        ]);

        //------------------------------------------//

        //Siemens ET200S
        $hardwareObjects[] = DB::table('hardware_objects')->insertGetId([
            'name' => 'ET200S',
            'type' => 'Buskoppler',
            'description' => '(Dezentrale Peripherie - F-Technik )',
            'vendor' => 'Siemens',
            'einfuehrungsjahr' => 2004,
        ]);

        //Schnittstellen nur über Module, deshalb hier nix

        //------------------------------------------//

        //SWITCHES
        //Scalance XB208
        $hardwareObjects[] = DB::table('hardware_objects')->insertGetId([
            'name' => 'Scalance XB208',
            'type' => 'Switch',
            'description' => 'managebarer Layer 2 IE Switch',
            'vendor' => 'Siemens',
            'einfuehrungsjahr' => 2015,
        ]);
        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[11],
            'interfacecategory_id' => $eId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[11],
            'interface_model_id' => $tempid,
            'maxConnections' => 9,
        ]);

        //Protokolle Ethernet
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 1, //Ethernet/ip
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 2, //Profinet
        ]);

        //------------------------------------------//

        //GS950/24 (Combo Web Smart Switch)
        $hardwareObjects[] = DB::table('hardware_objects')->insertGetId([
            'name' => 'GS950/24 (Combo Web Smart Switch)',
            'type' => 'Switch',
            'description' => '48-port 10/100/1000T eco-friendly WebSmart
switch with 4 SFP combo ports',
            'vendor' => 'Allied Telesis',
            'einfuehrungsjahr' => 2015,
        ]);

        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[12],
            'interfacecategory_id' => $eId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[12],
            'interface_model_id' => $tempid,
            'maxConnections' => 28,
        ]);

        //Protokolle Ethernet
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 1, //Ethernet/ip
        ]);

        //------------------------------------------//

        //CU2008
        $hardwareObjects[] = DB::table('hardware_objects')->insertGetId([
            'name' => 'CU2008',
            'type' => 'Switch',
            'description' => '',
            'vendor' => 'Beckhoff',
        ]);

        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[13],
            'interfacecategory_id' => $eId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[13],
            'interface_model_id' => $tempid,
            'maxConnections' => 8,
        ]);

        //Protokolle Ethernet
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 3, //Ethercat
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 4, //Twincat
        ]);

        //------------------------------------------//

        //FL SWITCH 7008-EIP
        $hardwareObjects[] = DB::table('hardware_objects')->insertGetId([
            'name' => 'FL SWITCH 7008-EIP',
            'type' => 'Switch',
            'description' => '',
            'vendor' => 'Phoenix Contact',
        ]);
        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[14],
            'interfacecategory_id' => $eId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[14],
            'interface_model_id' => $tempid,
            'maxConnections' => 8,
        ]);

        //Protokolle Ethernet
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 1, //Ethernet/ip
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 2, //Profinet
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 17, //snmp
        ]);

        //------------------------------------------//

        //CU8006
        $hardwareObjects[] = DB::table('hardware_objects')->insertGetId([
            'name' => 'CU8006',
            'type' => 'Switch',
            'description' => 'Network Hub, 4-Port-USB-3.0-Hub',
            'vendor' => 'Beckhoff',
        ]);

        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[15],
            'interfacecategory_id' => $uId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[15],
            'interface_model_id' => $tempid,
            'maxConnections' => 5,
        ]);

        //Hier keine Ethernet Schnittstelle/n eingetragen, daher keine Protokolle

        //------------------------------------------//

        //ROUTER
        //mbNET MDH 841
        $hardwareObjects[] = DB::table('hardware_objects')->insertGetId([
            'name' => 'MDH 841',
            'type' => 'Router',
            'description' => 'mbNET® Industrial router',
            'vendor' => 'Mbconnectline',
        ]);
        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[16],
            'interfacecategory_id' => $eId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[16],
            'interface_model_id' => $tempid,
            'maxConnections' => 4,
        ]);

        //Nur Fieldbus Protkolle???

        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[16],
            'interfacecategory_id' => $uId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[16],
            'interface_model_id' => $tempid,
            'maxConnections' => 1,
        ]);

        //------------------------------------------//

        //TC MGUARD RS4000 4G VPN
        $hardwareObjects[] = DB::table('hardware_objects')->insertGetId([
            'name' => 'TC MGUARD RS4000 4G VPN',
            'type' => 'Router',
            'description' => 'Industrieller 4G-Mobilfunk-Router (LTE) mit
integrierter Firewall und VPN',
            'vendor' => 'Phoenix Contact',

            'hasFirewall' => true,
        ]);
        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[17],
            'interfacecategory_id' => $eId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[17],
            'interface_model_id' => $tempid,
            'maxConnections' => 6,
        ]);

        //Protokolle Ethernet
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 1, //Ethernet/ip
        ]);

        //------------------------------------------//

        //IXRouter3 IX2400
        $hardwareObjects[] = DB::table('hardware_objects')->insertGetId([
            'name' => 'IXRouter3 IX2400',
            'type' => 'Router',
            'description' => 'IoT Gateway',
            'vendor' => 'IXON',
        ]);
        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[18],
            'interfacecategory_id' => $eId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[18],
            'interface_model_id' => $tempid,
            'maxConnections' => 5,
        ]);

        //Ethernet Protokolle
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 1, //Ethernet/ip
        ]);

        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[18],
            'interfacecategory_id' => $uId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[18],
            'interface_model_id' => $tempid,
            'maxConnections' => 1,
        ]);

        //------------------------------------------//

        //GATEWAY
        //EWON FLEXY201
        $hardwareObjects[] = DB::table('hardware_objects')->insertGetId([
            'name' => 'Flexy201',
            'type' => 'Gateway',
            'description' => 'industrial M2M Ewon-Router oder Ewon-Gateway auf Basis von 4 Ethernet-Ports.
(modular aufgebaut - über module definierbar ob Ewon Flexy 201, 202 oder 203 )',
            'vendor' => 'Ewon',
        ]);
        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[19],
            'interfacecategory_id' => $eId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[19],
            'interface_model_id' => $tempid,
            'maxConnections' => 1,
        ]);

        //Ethernet Protokolle
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 1, //Ethernet/ip
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 8, //Modbus TCP/IP
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 12, //TCP ISO on TCP UDP
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 17, //SNMP
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 49, //Other Ethernet
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 19, //OPC UA
        ]);

        //------------------------------------------//

        //Siemens IOT2000er
        $hardwareObjects[] = DB::table('hardware_objects')->insertGetId([
            'name' => 'IOT2000/20/40',
            'type' => 'Gateway',
            'description' => '',
            'vendor' => 'Siemens',
            'einfuehrungsjahr' => 2016,
        ]);
        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[20],
            'interfacecategory_id' => $uId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[20],
            'interface_model_id' => $tempid,
            'maxConnections' => 2,
        ]);
        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[20],
            'interfacecategory_id' => $fId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[20],
            'interface_model_id' => $tempid,
            'maxConnections' => 2,
        ]);
        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[20],
            'interfacecategory_id' => $eId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[20],
            'interface_model_id' => $tempid,
            'maxConnections' => 2,
        ]);

        //Ethernet Protokolle
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 1, //Ethernet/ip
        ]);

        //------------------------------------------//

        //HMI
        $hardwareObjects[] = DB::table('hardware_objects')->insertGetId([
            'name' => 'SIMATIC Basic Panel KTP400',
            'type' => 'HMI',
            'description' => '',
            'vendor' => 'Siemens',
            'einfuehrungsjahr' => 2014,
        ]);
        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[21],
            'interfacecategory_id' => $eId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[21],
            'interface_model_id' => $tempid,
            'maxConnections' => 1,
        ]);

        //Protokolle Ethernet
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 1, //Ethernet/ip
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 2, //Profinet
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 8, //Modbus TCP
        ]);

        //Protokolle Ethernet
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 1, //Ethernet/ip
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 2, //Profinet
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 8, //Modbus TCP
        ]);

        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[21],
            'interfacecategory_id' => $uId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[21],
            'interface_model_id' => $tempid,
            'maxConnections' => 1,
        ]);

        //------------------------------------------//

        $hardwareObjects[] = DB::table('hardware_objects')->insertGetId([
            'name' => 'CP6906-0001-0010',
            'type' => 'HMI',
            'description' => 'Economy-Einbau-Control-Panel mit DVI/USB-Extended-Anschluss',
            'vendor' => 'Beckhoff',
        ]);
        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[22],
            'interfacecategory_id' => $eId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[22],
            'interface_model_id' => $tempid,
            'maxConnections' => 2,
        ]);

        //Ethernet Protokolle
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 1, //Ethernet/ip
        ]);
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 49, //Other Ethernet
        ]);

        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[22],
            'interfacecategory_id' => $uId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[22],
            'interface_model_id' => $tempid,
            'maxConnections' => 3,
        ]);

        //------------------------------------------//

        $hardwareObjects[] = DB::table('hardware_objects')->insertGetId([
            'name' => 'Touchpanel - BTP 2070W',
            'type' => 'HMI',
            'description' => '',
            'vendor' => 'Phoenix Contact',
        ]);
        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[23],
            'interfacecategory_id' => $eId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[23],
            'interface_model_id' => $tempid,
            'maxConnections' => 1,
        ]);

        //Ethernet Protokolle
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 1, //Ethernet/ip
        ]);

        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[23],
            'interfacecategory_id' => $uId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[23],
            'interface_model_id' => $tempid,
            'maxConnections' => 2,
        ]);

        //------------------------------------------//

        //FIREWALL
        $hardwareObjects[] = DB::table('hardware_objects')->insertGetId([
            'name' => 'FortiGate Rugged 60 D',
            'type' => 'Firewall',
            'description' => '',
            'vendor' => 'Fortinet',

            'hasFirewall' => true,
        ]);
        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[24],
            'interfacecategory_id' => $eId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[24],
            'interface_model_id' => $tempid,
            'maxConnections' => 7,
        ]);

        //Ethernet Protokolle
        DB::table('interface_protocol')->insert([
            'interface_model_id' => $tempid,
            'protocol_id' => 1, //Ethernet/ip
        ]);

        $tempid = DB::table('interface_models')->insertGetId([
            'hardware_object_id' => $hardwareObjects[24],
            'interfacecategory_id' => $uId,
        ]);
        DB::table('hardware_object_interface_model')->insert([
            'hardware_object_id' => $hardwareObjects[24],
            'interface_model_id' => $tempid,
            'maxConnections' => 2,
        ]);
    }
}
