<!DOCTYPE html>
<html>
<head>
    <title>Network Flows</title>
    <link href="/css/banner.css" rel="stylesheet">
    <link href="/css/menu.css" rel="stylesheet">
    <link href="/css/network.css" rel="stylesheet">
    <script src="/js/jquery-1.11.1.min.js"></script>
    <script src="/js/menu.js"></script>
</head>

<body>
    <div id="banner">
        <img id="bannerImg" src="/images/directv-logo2.png">

        <div id="bannerText"></div>
    </div>

    <div id="nav">
        <ul>
            <li id="lisacatalog">
                <a href="http://147.22.243.86:8080/lisacatalog/lisacatalog.php"
                title=
                "Catalog of all deployed services on each LISA Instance server.">
                LISA Catalog</a>
            </li>

            <li id="nomatches">
                <a href="http://147.22.243.86:8080/nomatches/nomatches.php"
                title="Report of No-Match warnings against LISA stubs.">No
                Match</a>
            </li>

            <li id="soatest">
                <a href="http://147.22.243.86:8080/soatest/soalicense.php"
                title=
                "Chart of SOAtest license usage per user/machine.">SOAtest
                License</a>
            </li>

            <li id="networkflows">
                <a href=
                "http://147.22.243.86:8080/networkflows/SQANetworkFlows.php"
                title=
                "Reference table of network connection information.">Network
                Reference</a>
            </li>

            <li id="metrics">
                <a href="http://147.22.243.86:8080/metrics/metrics.php" title=
                "Overview of Stub info.">LISA Metrics</a>
            </li>
        </ul><script type="text/javascript">


        //Highlight menu item and update banner name
        var regex = /\/([^\/]*)\//; //Grab content between backslashes
        var path = window.location.pathname;
        var base = regex.exec(path);
        var currentPage;
        $("*[id*="+base[1]+"]:visible").each(function(){
            $(this).addClass("highlight");
            currentPage = $(this).text();
        }); 
        $("#bannerText").text(currentPage);

        </script>
    </div>

    <div id="page-wrap">
        <div id="search">
            <h3>Query Options:</h3>

            <form action='/networkflows/SQANetworkFlows.php' method='post'>
                <table>
                    <tr>
                        <td><b>Environment:</b><br>
                        <input name="Environment[]" type='checkbox' value=
                        "Dev">Dev<br>
                        <input name="Environment[]" type='checkbox' value=
                        "Engineering">Engineering<br>
                        <input name="Environment[]" type='checkbox' value=
                        "Prod">Prod<br>
                        <input name="Environment[]" type='checkbox' value=
                        "R1">R1<br>
                        <input name="Environment[]" type='checkbox' value=
                        "R3">R3<br>
                        <input name="Environment[]" type='checkbox' value=
                        "R5">R5<br>
                        <input name="Environment[]" type='checkbox' value=
                        "Sources">Sources<br>
                        <input name="Environment[]" type='checkbox' value=
                        "Tools">Tools<br></td>

                        <td><b>Type:</b><br>
                        <input name="Type[]" type='checkbox' value=
                        "Application">Application<br>
                        <input name="Type[]" type='checkbox' value=
                        "Tester">Tester<br></td>

                        <td><b>SourceLocation:</b><br>
                        <select name="SourceLocation">
                            <option value=''>
                                </option>

                            <option value='AMDOCS'>
                                AMDOCS
                            </option>

                            <option value='AT&T'>
                                AT&T
                            </option>

                            <option value='Amdocs'>
                                Amdocs
                            </option>

                            <option value='Answer Station'>
                                Answer Station
                            </option>

                            <option value='Astadia'>
                                Astadia
                            </option>

                            <option value='Boise'>
                                Boise
                            </option>

                            <option value='Brazil'>
                                Brazil
                            </option>

                            <option value='Bridgevine'>
                                Bridgevine
                            </option>

                            <option value='Bridgevine (Testers)'>
                                Bridgevine (Testers)
                            </option>

                            <option value='Broadstar'>
                                Broadstar
                            </option>

                            <option value='CRBC'>
                                CRBC
                            </option>

                            <option value='CRBC?'>
                                CRBC?
                            </option>

                            <option value='Call Center (unknown name)'>
                                Call Center (unknown name)
                            </option>

                            <option value='Cignium'>
                                Cignium
                            </option>

                            <option value=
                            'Controller (GDMSLR04.crmdev.dtv.cxo.dec.com)'>
                                Controller (GDMSLR04.crmdev.dtv.cxo.dec.com)
                            </option>

                            <option value=
                            'Controller (VWSLQA10.mgmt.directv.com)'>
                                Controller (VWSLQA10.mgmt.directv.com)
                            </option>

                            <option value='Controllers'>
                                Controllers
                            </option>

                            <option value=
                            'Corporate Network Cisco VPN Wireless'>
                                Corporate Network Cisco VPN Wireless
                            </option>

                            <option value='DEN & Greenwood (Denver IT Office)'>
                                DEN & Greenwood (Denver IT Office)
                            </option>

                            <option value='DIRECTV VPN'>
                                DIRECTV VPN
                            </option>

                            <option value='DTV'>
                                DTV
                            </option>

                            <option value='DTV (D-E72391)'>
                                DTV (D-E72391)
                            </option>

                            <option value='DTV (D4INQA01)'>
                                DTV (D4INQA01)
                            </option>

                            <option value='DTV (D4INQA02)'>
                                DTV (D4INQA02)
                            </option>

                            <option value='DTV Internal - Boise'>
                                DTV Internal - Boise
                            </option>

                            <option value='DTV Internal - DEN'>
                                DTV Internal - DEN
                            </option>

                            <option value='DTV Internal - LA'>
                                DTV Internal - LA
                            </option>

                            <option value='DTV Internal - Missoula'>
                                DTV Internal - Missoula
                            </option>

                            <option value='DTV Internal - NY'>
                                DTV Internal - NY
                            </option>

                            <option value='DTV Internal - Wireless'>
                                DTV Internal - Wireless
                            </option>

                            <option value='DTV/LA3 (D-E65846)'>
                                DTV/LA3 (D-E65846)
                            </option>

                            <option value='Denver'>
                                Denver
                            </option>

                            <option value='Denver DC'>
                                Denver DC
                            </option>

                            <option value='Denver DC, LR Injector'>
                                Denver DC, LR Injector
                            </option>

                            <option value='Denver Data Center'>
                                Denver Data Center
                            </option>

                            <option value='Denver HSP'>
                                Denver HSP
                            </option>

                            <option value='El Segundo'>
                                El Segundo
                            </option>

                            <option value='El Segundo Wireless '>
                                El Segundo Wireless
                            </option>

                            <option value='El Segundo (LA Grand)'>
                                El Segundo (LA Grand)
                            </option>

                            <option value='El Segundo (LA1 Wireless)'>
                                El Segundo (LA1 Wireless)
                            </option>

                            <option value='El Segundo (LA1)'>
                                El Segundo (LA1)
                            </option>

                            <option value='El Segundo (LA2 + Wireless)'>
                                El Segundo (LA2 + Wireless)
                            </option>

                            <option value='El Segundo (LA2 Wireless)'>
                                El Segundo (LA2 Wireless)
                            </option>

                            <option value='El Segundo (LA2)'>
                                El Segundo (LA2)
                            </option>

                            <option value='El Segundo (LA3 Wireless)'>
                                El Segundo (LA3 Wireless)
                            </option>

                            <option value='El Segundo (LA3)'>
                                El Segundo (LA3)
                            </option>

                            <option value='El Segundo (Wireless)'>
                                El Segundo (Wireless)
                            </option>

                            <option value='El Segundo LA2'>
                                El Segundo LA2
                            </option>

                            <option value='Empereon'>
                                Empereon
                            </option>

                            <option value='Emperon'>
                                Emperon
                            </option>

                            <option value='Engineering'>
                                Engineering
                            </option>

                            <option value='FaceBook'>
                                FaceBook
                            </option>

                            <option value='Fairpoint (MD, NH, VT)'>
                                Fairpoint (MD, NH, VT)
                            </option>

                            <option value='Greenwood (Denver IT Office)'>
                                Greenwood (Denver IT Office)
                            </option>

                            <option value='HP'>
                                HP
                            </option>

                            <option value='HP "Stub" Server'>
                                HP "Stub" Server
                            </option>

                            <option value='HP (GDMSLR01)'>
                                HP (GDMSLR01)
                            </option>

                            <option value='HP (GDMSLR02)'>
                                HP (GDMSLR02)
                            </option>

                            <option value='HP (GDMSLR03)'>
                                HP (GDMSLR03)
                            </option>

                            <option value='HP (GDMSLR05)'>
                                HP (GDMSLR05)
                            </option>

                            <option value='HP (GDMSLR07)'>
                                HP (GDMSLR07)
                            </option>

                            <option value='HP (GDMSLR09)'>
                                HP (GDMSLR09)
                            </option>

                            <option value='HP (GDMSLR10)'>
                                HP (GDMSLR10)
                            </option>

                            <option value='HP CXO'>
                                HP CXO
                            </option>

                            <option value='HP SWA'>
                                HP SWA
                            </option>

                            <option value='HP Testers'>
                                HP Testers
                            </option>

                            <option value='HP Testers, Admins (CXO)'>
                                HP Testers, Admins (CXO)
                            </option>

                            <option value='IBM'>
                                IBM
                            </option>

                            <option value='IBM Brazil'>
                                IBM Brazil
                            </option>

                            <option value='IBM Brazil (External)'>
                                IBM Brazil (External)
                            </option>

                            <option value='IBM Brazil (Internal)'>
                                IBM Brazil (Internal)
                            </option>

                            <option value='IBM Brazil (external)'>
                                IBM Brazil (external)
                            </option>

                            <option value='IBM Brazil External'>
                                IBM Brazil External
                            </option>

                            <option value='IBM Brazil Internal'>
                                IBM Brazil Internal
                            </option>

                            <option value='IBM External IPs'>
                                IBM External IPs
                            </option>

                            <option value='IBM India'>
                                IBM India
                            </option>

                            <option value='IBM India (External)'>
                                IBM India (External)
                            </option>

                            <option value='IBM India (Internal)'>
                                IBM India (Internal)
                            </option>

                            <option value='IBM India External'>
                                IBM India External
                            </option>

                            <option value='IBM India Internal'>
                                IBM India Internal
                            </option>

                            <option value='Injectors'>
                                Injectors
                            </option>

                            <option value='LA El Segundo'>
                                LA El Segundo
                            </option>

                            <option value='LA Grand'>
                                LA Grand
                            </option>

                            <option value='LA Grand Wireless'>
                                LA Grand Wireless
                            </option>

                            <option value='LA1 (Legal)'>
                                LA1 (Legal)
                            </option>

                            <option value='LA1 El Segundo'>
                                LA1 El Segundo
                            </option>

                            <option value='LA2'>
                                LA2
                            </option>

                            <option value='LA2 Wireless'>
                                LA2 Wireless
                            </option>

                            <option value='LA3'>
                                LA3
                            </option>

                            <option value='LA3 Wireless'>
                                LA3 Wireless
                            </option>

                            <option value='LADC'>
                                LADC
                            </option>

                            <option value='LISA (Dotcom Instance)'>
                                LISA (Dotcom Instance)
                            </option>

                            <option value='LR SWA -- OOM'>
                                LR SWA -- OOM
                            </option>

                            <option value='Maryland Training Ctr'>
                                Maryland Training Ctr
                            </option>

                            <option value='Missoula'>
                                Missoula
                            </option>

                            <option value='NCA'>
                                NCA
                            </option>

                            <option value='NY Office'>
                                NY Office
                            </option>

                            <option value='OPS DataCon Team'>
                                OPS DataCon Team
                            </option>

                            <option value='Oracle'>
                                Oracle
                            </option>

                            <option value='PHX'>
                                PHX
                            </option>

                            <option value='PRC'>
                                PRC
                            </option>

                            <option value='Phoenix'>
                                Phoenix
                            </option>

                            <option value='Phoenix Data Center'>
                                Phoenix Data Center
                            </option>

                            <option value='PowerDirect'>
                                PowerDirect
                            </option>

                            <option value='QATS Boise'>
                                QATS Boise
                            </option>

                            <option value='QATS Denver'>
                                QATS Denver
                            </option>

                            <option value='QATS El Segundo'>
                                QATS El Segundo
                            </option>

                            <option value='QATS Wireless'>
                                QATS Wireless
                            </option>

                            <option value='QC Dev'>
                                QC Dev
                            </option>

                            <option value='QC Prod'>
                                QC Prod
                            </option>

                            <option value='QWEST_INET'>
                                QWEST_INET
                            </option>

                            <option value='Qwest'>
                                Qwest
                            </option>

                            <option value='RIO Dev (LA2/8th Floor'>
                                RIO Dev (LA2/8th Floor
                            </option>

                            <option value='SFDC'>
                                SFDC
                            </option>

                            <option value='SOAtest License Server (new)'>
                                SOAtest License Server (new)
                            </option>

                            <option value='SOAtest on Stub Server'>
                                SOAtest on Stub Server
                            </option>

                            <option value='SQA Boise'>
                                SQA Boise
                            </option>

                            <option value='SQA Missoula'>
                                SQA Missoula
                            </option>

                            <option value='Stub Server (HP)'>
                                Stub Server (HP)
                            </option>

                            <option value='Tranzact'>
                                Tranzact
                            </option>

                            <option value='Tranzact (NJ)'>
                                Tranzact (NJ)
                            </option>

                            <option value='Tranzact Testers'>
                                Tranzact Testers
                            </option>

                            <option value='Tranzact Testers Injectors'>
                                Tranzact Testers Injectors
                            </option>

                            <option value='UAT Boise'>
                                UAT Boise
                            </option>

                            <option value='UAT Testers'>
                                UAT Testers
                            </option>

                            <option value='VPN'>
                                VPN
                            </option>

                            <option value='VPN '>
                                VPN
                            </option>

                            <option value='VPN (Den & LA)'>
                                VPN (Den & LA)
                            </option>

                            <option value='VPN (Denver)'>
                                VPN (Denver)
                            </option>

                            <option value='VPN (LA)'>
                                VPN (LA)
                            </option>

                            <option value='VXI'>
                                VXI
                            </option>

                            <option value='Verizon'>
                                Verizon
                            </option>

                            <option value='West'>
                                West
                            </option>

                            <option value='West, Omaha'>
                                West, Omaha
                            </option>

                            <option value='WiPro'>
                                WiPro
                            </option>

                            <option value='Wipro'>
                                Wipro
                            </option>

                            <option value='Wipro India'>
                                Wipro India
                            </option>

                            <option value='Wireless'>
                                Wireless
                            </option>

                            <option value='Young America'>
                                Young America
                            </option>

                            <option value='eTelecare'>
                                eTelecare
                            </option>

                            <option value='iTKO LISA VSE'>
                                iTKO LISA VSE
                            </option>
                        </select><br>
                        <b>Source:</b><br>
                        <select name="Source">
                            <option value=''>
                                </option>

                            <option value='.COM'>
                                .COM
                            </option>

                            <option value='?'>
                                ?
                            </option>

                            <option value='??'>
                                ??
                            </option>

                            <option value='ADAPT/EDAPT'>
                                ADAPT/EDAPT
                            </option>

                            <option value='ADMI'>
                                ADMI
                            </option>

                            <option value=
                            'ADMI (Some of the Source IPs might be developer machines)'>
                            ADMI (Some of the Source IPs might be developer
                            machines)
                            </option>

                            <option value=
                            'ADMI or Auth Server (Some of the Source IPs might be developer machines)'>
                            ADMI or Auth Server (Some of the Source IPs might
                            be developer machines)
                            </option>

                            <option value='ASMM'>
                                ASMM
                            </option>

                            <option value='ASMM (App)'>
                                ASMM (App)
                            </option>

                            <option value='ASMM (DB)'>
                                ASMM (DB)
                            </option>

                            <option value='ASMM (app)'>
                                ASMM (app)
                            </option>

                            <option value='AT&T Testers'>
                                AT&T Testers
                            </option>

                            <option value='Amdocs'>
                                Amdocs
                            </option>

                            <option value='Analytics'>
                                Analytics
                            </option>

                            <option value='Answer Station'>
                                Answer Station
                            </option>

                            <option value='Astadia Testers'>
                                Astadia Testers
                            </option>

                            <option value='BI Testers'>
                                BI Testers
                            </option>

                            <option value='Bridgevine Testers'>
                                Bridgevine Testers
                            </option>

                            <option value='Broadstar'>
                                Broadstar
                            </option>

                            <option value='Broadstar Testers'>
                                Broadstar Testers
                            </option>

                            <option value='C3'>
                                C3
                            </option>

                            <option value='CCU'>
                                CCU
                            </option>

                            <option value='CE ADMI'>
                                CE ADMI
                            </option>

                            <option value='CE ASMI'>
                                CE ASMI
                            </option>

                            <option value='CE Auth Server'>
                                CE Auth Server
                            </option>

                            <option value='CSI'>
                                CSI
                            </option>

                            <option value='Call Center Testers'>
                                Call Center Testers
                            </option>

                            <option value='Cignium Testers'>
                                Cignium Testers
                            </option>

                            <option value='Controller'>
                                Controller
                            </option>

                            <option value=
                            'Controller (GDMSLR04.crmdev.dtv.cxo.dec.com)'>
                                Controller (GDMSLR04.crmdev.dtv.cxo.dec.com)
                            </option>

                            <option value=
                            'Controller (VWSLQA10.mgmt.directv.com)'>
                                Controller (VWSLQA10.mgmt.directv.com)
                            </option>

                            <option value='DB monitoring'>
                                DB monitoring
                            </option>

                            <option value='DIRECTV.com'>
                                DIRECTV.com
                            </option>

                            <option value='DTV NY'>
                                DTV NY
                            </option>

                            <option value='DWS'>
                                DWS
                            </option>

                            <option value='Denver'>
                                Denver
                            </option>

                            <option value='E2E Activation Server'>
                                E2E Activation Server
                            </option>

                            <option value='E2E Auth Server'>
                                E2E Auth Server
                            </option>

                            <option value='EPS/ASMM Rep'>
                                EPS/ASMM Rep
                            </option>

                            <option value='Emperon'>
                                Emperon
                            </option>

                            <option value='Engineering'>
                                Engineering
                            </option>

                            <option value='FaceBook'>
                                FaceBook
                            </option>

                            <option value='Fairpoint Telco'>
                                Fairpoint Telco
                            </option>

                            <option value='GG (ZLDS; Non-stop)'>
                                GG (ZLDS; Non-stop)
                            </option>

                            <option value='HP Testers'>
                                HP Testers
                            </option>

                            <option value='IBM Brazil (External)'>
                                IBM Brazil (External)
                            </option>

                            <option value='IBM Brazil (Internal)'>
                                IBM Brazil (Internal)
                            </option>

                            <option value='IBM India (External)'>
                                IBM India (External)
                            </option>

                            <option value='IBM India (Internal)'>
                                IBM India (Internal)
                            </option>

                            <option value='IBM Testers'>
                                IBM Testers
                            </option>

                            <option value='ICAN'>
                                ICAN
                            </option>

                            <option value='ICAN '>
                                ICAN
                            </option>

                            <option value='ICAN (LH5)'>
                                ICAN (LH5)
                            </option>

                            <option value='IMEflex'>
                                IMEflex
                            </option>

                            <option value='ISA'>
                                ISA
                            </option>

                            <option value='IVR'>
                                IVR
                            </option>

                            <option value='Imperva GW'>
                                Imperva GW
                            </option>

                            <option value='Imperva Mgmt'>
                                Imperva Mgmt
                            </option>

                            <option value='Injector'>
                                Injector
                            </option>

                            <option value='LA Grand'>
                                LA Grand
                            </option>

                            <option value='LA Grand Wireless'>
                                LA Grand Wireless
                            </option>

                            <option value='LA1'>
                                LA1
                            </option>

                            <option value='LA1 Wireless'>
                                LA1 Wireless
                            </option>

                            <option value='LA3'>
                                LA3
                            </option>

                            <option value='LA3 Wireless'>
                                LA3 Wireless
                            </option>

                            <option value='LIL EJB'>
                                LIL EJB
                            </option>

                            <option value='LISA'>
                                LISA
                            </option>

                            <option value='LR (Injector)'>
                                LR (Injector)
                            </option>

                            <option value='LTM'>
                                LTM
                            </option>

                            <option value='Load Runner'>
                                Load Runner
                            </option>

                            <option value='OBIEE'>
                                OBIEE
                            </option>

                            <option value='OMS'>
                                OMS
                            </option>

                            <option value='OMS/OS'>
                                OMS/OS
                            </option>

                            <option value='OPS DataCon Team'>
                                OPS DataCon Team
                            </option>

                            <option value='OSCAR'>
                                OSCAR
                            </option>

                            <option value='Oracle'>
                                Oracle
                            </option>

                            <option value='QWEST_INET'>
                                QWEST_INET
                            </option>

                            <option value='Qwest Testers'>
                                Qwest Testers
                            </option>

                            <option value='RCA'>
                                RCA
                            </option>

                            <option value='RIO'>
                                RIO
                            </option>

                            <option value='RSN Provision'>
                                RSN Provision
                            </option>

                            <option value='Rio'>
                                Rio
                            </option>

                            <option value='Rio (AIX)'>
                                Rio (AIX)
                            </option>

                            <option value='Rio Workflow Server'>
                                Rio Workflow Server
                            </option>

                            <option value='SAP CRM'>
                                SAP CRM
                            </option>

                            <option value='SAP CRM '>
                                SAP CRM
                            </option>

                            <option value='SFDC'>
                                SFDC
                            </option>

                            <option value='SOAtest License Server'>
                                SOAtest License Server
                            </option>

                            <option value='SPC'>
                                SPC
                            </option>

                            <option value='SQA Boise'>
                                SQA Boise
                            </option>

                            <option value='SQA Missoula'>
                                SQA Missoula
                            </option>

                            <option value='SQA Team'>
                                SQA Team
                            </option>

                            <option value='SQA Testers'>
                                SQA Testers
                            </option>

                            <option value='Sales App'>
                                Sales App
                            </option>

                            <option value='Security Team'>
                                Security Team
                            </option>

                            <option value='SeeBeyond Broker'>
                                SeeBeyond Broker
                            </option>

                            <option value='Service Broker OMS'>
                                Service Broker OMS
                            </option>

                            <option value='Service Broker OMS'>
                                Service Broker OMS
                            </option>

                            <option value='Servlets'>
                                Servlets
                            </option>

                            <option value='Stub Server'>
                                Stub Server
                            </option>

                            <option value='Stub Server (HP)'>
                                Stub Server (HP)
                            </option>

                            <option value='Subnet'>
                                Subnet
                            </option>

                            <option value='TAOS'>
                                TAOS
                            </option>

                            <option value='TBD'>
                                TBD
                            </option>

                            <option value='TCS'>
                                TCS
                            </option>

                            <option value='TCS Dev'>
                                TCS Dev
                            </option>

                            <option value='TEST DDC'>
                                TEST DDC
                            </option>

                            <option value='TEST PDC'>
                                TEST PDC
                            </option>

                            <option value='Telco'>
                                Telco
                            </option>

                            <option value='Tranzact'>
                                Tranzact
                            </option>

                            <option value='UAT Testers'>
                                UAT Testers
                            </option>

                            <option value='VDI'>
                                VDI
                            </option>

                            <option value='VPN (Denver)'>
                                VPN (Denver)
                            </option>

                            <option value='VPN (LA)'>
                                VPN (LA)
                            </option>

                            <option value='Verizon'>
                                Verizon
                            </option>

                            <option value='West (Dev/Preprod)'>
                                West (Dev/Preprod)
                            </option>

                            <option value='West (Internal)'>
                                West (Internal)
                            </option>

                            <option value='West (Internet)'>
                                West (Internet)
                            </option>

                            <option value='West Team'>
                                West Team
                            </option>

                            <option value='Wipro Team'>
                                Wipro Team
                            </option>

                            <option value='ZLDS'>
                                ZLDS
                            </option>

                            <option value='ZLDS (Blade)'>
                                ZLDS (Blade)
                            </option>

                            <option value='ZLDS (S-Series)'>
                                ZLDS (S-Series)
                            </option>

                            <option value='eGate'>
                                eGate
                            </option>

                            <option value='eTrust'>
                                eTrust
                            </option>

                            <option value='iPhone'>
                                iPhone
                            </option>

                            <option value='iTKO LISA VSE'>
                                iTKO LISA VSE
                            </option>

                            <option value='vxtdtd01'>
                                vxtdtd01
                            </option>
                        </select><br>
                        <b>DestinationLocation:</b><br>
                        <select name="DestinationLocation">
                            <option value=''>
                                </option>

                            <option value='ATT'>
                                ATT
                            </option>

                            <option value='Acceller'>
                                Acceller
                            </option>

                            <option value='AllConnect'>
                                AllConnect
                            </option>

                            <option value='Broadstar'>
                                Broadstar
                            </option>

                            <option value='CRBC'>
                                CRBC
                            </option>

                            <option value='DEN'>
                                DEN
                            </option>

                            <option value='DEN & PHX'>
                                DEN & PHX
                            </option>

                            <option value='DENVER'>
                                DENVER
                            </option>

                            <option value='Den & Phx'>
                                Den & Phx
                            </option>

                            <option value='Denver'>
                                Denver
                            </option>

                            <option value='Denver & Phoenix'>
                                Denver & Phoenix
                            </option>

                            <option value='Denver DC'>
                                Denver DC
                            </option>

                            <option value='Denver/Phoenix'>
                                Denver/Phoenix
                            </option>

                            <option value='El Segundo'>
                                El Segundo
                            </option>

                            <option value='El Segundo Data Center'>
                                El Segundo Data Center
                            </option>

                            <option value='Engineering'>
                                Engineering
                            </option>

                            <option value='Engineering (EE)'>
                                Engineering (EE)
                            </option>

                            <option value='Engineering (PI)'>
                                Engineering (PI)
                            </option>

                            <option value='Engineering CRBC'>
                                Engineering CRBC
                            </option>

                            <option value='Engineering LADC'>
                                Engineering LADC
                            </option>

                            <option value='Engr'>
                                Engr
                            </option>

                            <option value='Fairpoint (MD, NH, VT)'>
                                Fairpoint (MD, NH, VT)
                            </option>

                            <option value='Gomez'>
                                Gomez
                            </option>

                            <option value='HP'>
                                HP
                            </option>

                            <option value='HP CXO'>
                                HP CXO
                            </option>

                            <option value='HP SWA'>
                                HP SWA
                            </option>

                            <option value='Internet Accesible Proxy - DTV'>
                                Internet Accesible Proxy - DTV
                            </option>

                            <option value='LA 2'>
                                LA 2
                            </option>

                            <option value='LA2'>
                                LA2
                            </option>

                            <option value='LABC'>
                                LABC
                            </option>

                            <option value='LABC/CRBC'>
                                LABC/CRBC
                            </option>

                            <option value='LADC'>
                                LADC
                            </option>

                            <option value='LADC Engineering'>
                                LADC Engineering
                            </option>

                            <option value='LADC(?)'>
                                LADC(?)
                            </option>

                            <option value='NCA'>
                                NCA
                            </option>

                            <option value='PHX'>
                                PHX
                            </option>

                            <option value='PHX?'>
                                PHX?
                            </option>

                            <option value='Phoenix'>
                                Phoenix
                            </option>

                            <option value='Phoenix DC'>
                                Phoenix DC
                            </option>

                            <option value='Rio Churn Macro'>
                                Rio Churn Macro
                            </option>

                            <option value='SFDC'>
                                SFDC
                            </option>

                            <option value='SWA'>
                                SWA
                            </option>

                            <option value='Tranzact'>
                                Tranzact
                            </option>

                            <option value='Tranzact (NJ)'>
                                Tranzact (NJ)
                            </option>

                            <option value='Tranzact NJ'>
                                Tranzact NJ
                            </option>

                            <option value='VIP'>
                                VIP
                            </option>

                            <option value='Verizon'>
                                Verizon
                            </option>

                            <option value='West'>
                                West
                            </option>

                            <option value='x'>
                                x
                            </option>
                        </select><br>
                        <b>Destination:</b><br>
                        <select name="Destination">
                            <option value=''>
                                </option>

                            <option value='.COM'>
                                .COM
                            </option>

                            <option value='.com Sys'>
                                .com Sys
                            </option>

                            <option value='.com Sys Ref'>
                                .com Sys Ref
                            </option>

                            <option value='.com Sys Ref2'>
                                .com Sys Ref2
                            </option>

                            <option value='.com contentstaging'>
                                .com contentstaging
                            </option>

                            <option value='1xEFT'>
                                1xEFT
                            </option>

                            <option value='ACTS (ora-actstst)'>
                                ACTS (ora-actstst)
                            </option>

                            <option value='ADE'>
                                ADE
                            </option>

                            <option value='ADE Project 1 - Test Harness'>
                                ADE Project 1 - Test Harness
                            </option>

                            <option value='ADE VIPs'>
                                ADE VIPs
                            </option>

                            <option value='AS'>
                                AS
                            </option>

                            <option value='ASMM'>
                                ASMM
                            </option>

                            <option value='ASMM (app: r5ams10u)'>
                                ASMM (app: r5ams10u)
                            </option>

                            <option value='ASMM (App)'>
                                ASMM (App)
                            </option>

                            <option value='ASMM App'>
                                ASMM App
                            </option>

                            <option value='ASMM DB'>
                                ASMM DB
                            </option>

                            <option value=
                            'ASMM Joint Billing Configuration Tool'>
                                ASMM Joint Billing Configuration Tool
                            </option>

                            <option value='Acceller'>
                                Acceller
                            </option>

                            <option value='Actuate Report Server'>
                                Actuate Report Server
                            </option>

                            <option value='AllConnect'>
                                AllConnect
                            </option>

                            <option value='Altiris (new)'>
                                Altiris (new)
                            </option>

                            <option value='Altiris (old)'>
                                Altiris (old)
                            </option>

                            <option value='Altiris Server (New)'>
                                Altiris Server (New)
                            </option>

                            <option value='Altiris Server (Old)'>
                                Altiris Server (Old)
                            </option>

                            <option value='Analytics'>
                                Analytics
                            </option>

                            <option value='BI Publisher'>
                                BI Publisher
                            </option>

                            <option value='Broadstar'>
                                Broadstar
                            </option>

                            <option value='C3'>
                                C3
                            </option>

                            <option value='C3 Admin Node'>
                                C3 Admin Node
                            </option>

                            <option value='C3 Closing Offers'>
                                C3 Closing Offers
                            </option>

                            <option value='C3 D1A'>
                                C3 D1A
                            </option>

                            <option value='C3 DB'>
                                C3 DB
                            </option>

                            <option value='C3 Training PROD'>
                                C3 Training PROD
                            </option>

                            <option value='C3(offers.directv.com)'>
                                C3(offers.directv.com)
                            </option>

                            <option value='C3, EI Injectors'>
                                C3, EI Injectors
                            </option>

                            <option value='CA Workload Control Center'>
                                CA Workload Control Center
                            </option>

                            <option value='CASH'>
                                CASH
                            </option>

                            <option value='CASH DB'>
                                CASH DB
                            </option>

                            <option value='CAWS'>
                                CAWS
                            </option>

                            <option value='CLICK Agents Servers'>
                                CLICK Agents Servers
                            </option>

                            <option value='CLICK Agents VIP'>
                                CLICK Agents VIP
                            </option>

                            <option value='CLICK Analyze Server'>
                                CLICK Analyze Server
                            </option>

                            <option value='CLICK Analyze Servers'>
                                CLICK Analyze Servers
                            </option>

                            <option value='CLICK Analyze VIP'>
                                CLICK Analyze VIP
                            </option>

                            <option value='CLICK GIS Servers'>
                                CLICK GIS Servers
                            </option>

                            <option value='CLICK GIS VIP'>
                                CLICK GIS VIP
                            </option>

                            <option value=
                            'CLICK Integration/Offline Agents Servers'>
                                CLICK Integration/Offline Agents Servers
                            </option>

                            <option value=
                            'CLICK Integration/Offline Agents VIP'>
                                CLICK Integration/Offline Agents VIP
                            </option>

                            <option value='CLICK Reporting Server (MS SSRS)'>
                                CLICK Reporting Server (MS SSRS)
                            </option>

                            <option value='CLICK Reporting Servers (MS SSRS)'>
                                CLICK Reporting Servers (MS SSRS)
                            </option>

                            <option value='CLICK Reporting VIP'>
                                CLICK Reporting VIP
                            </option>

                            <option value='CLICK Scheduler Dispatcher Servers'>
                                CLICK Scheduler Dispatcher Servers
                            </option>

                            <option value='CLICK Scheduler Dispatcher VIP'>
                                CLICK Scheduler Dispatcher VIP
                            </option>

                            <option value='CLICK Web VIP'>
                                CLICK Web VIP
                            </option>

                            <option value='CTI'>
                                CTI
                            </option>

                            <option value='CTS'>
                                CTS
                            </option>

                            <option value='Cartman'>
                                Cartman
                            </option>

                            <option value='Collabrent'>
                                Collabrent
                            </option>

                            <option value='Comergent'>
                                Comergent
                            </option>

                            <option value='Comergent BAU DD'>
                                Comergent BAU DD
                            </option>

                            <option value='Comergent (External)'>
                                Comergent (External)
                            </option>

                            <option value='Comergent (Internal)'>
                                Comergent (Internal)
                            </option>

                            <option value='Comergent (external)'>
                                Comergent (external)
                            </option>

                            <option value='Comergent (external) BAU DD'>
                                Comergent (external) BAU DD
                            </option>

                            <option value='Controller'>
                                Controller
                            </option>

                            <option value='DEN'>
                                DEN
                            </option>

                            <option value='DIRECTV.com'>
                                DIRECTV.com
                            </option>

                            <option value='DIRECTV.com (dtvprd)'>
                                DIRECTV.com (dtvprd)
                            </option>

                            <option value='DIRECTV.com edapt'>
                                DIRECTV.com edapt
                            </option>

                            <option value='DORIS'>
                                DORIS
                            </option>

                            <option value='DTSS Traffic File Share'>
                                DTSS Traffic File Share
                            </option>

                            <option value='DTV Webmail'>
                                DTV Webmail
                            </option>

                            <option value='DTVEDAPT'>
                                DTVEDAPT
                            </option>

                            <option value='DWS'>
                                DWS
                            </option>

                            <option value='DWS (DB)'>
                                DWS (DB)
                            </option>

                            <option value='DWS (Web Services)'>
                                DWS (Web Services)
                            </option>

                            <option value='DWS (app)'>
                                DWS (app)
                            </option>

                            <option value='DWS DB'>
                                DWS DB
                            </option>

                            <option value='DWS DB (DMZT)'>
                                DWS DB (DMZT)
                            </option>

                            <option value='DWS Injector'>
                                DWS Injector
                            </option>

                            <option value='DWS VIP for Web Services'>
                                DWS VIP for Web Services
                            </option>

                            <option value='Directv Webmail'>
                                Directv Webmail
                            </option>

                            <option value='Dotcom'>
                                Dotcom
                            </option>

                            <option value='Dotcom File Shares'>
                                Dotcom File Shares
                            </option>

                            <option value='Dotcom Tool'>
                                Dotcom Tool
                            </option>

                            <option value='Dotcom tool?'>
                                Dotcom tool?
                            </option>

                            <option value='Dwsrta03 (eGate Share?)'>
                                Dwsrta03 (eGate Share?)
                            </option>

                            <option value='ECS'>
                                ECS
                            </option>

                            <option value='EDM'>
                                EDM
                            </option>

                            <option value='EI DOCS'>
                                EI DOCS
                            </option>

                            <option value='EI OPS XML Upload Tool'>
                                EI OPS XML Upload Tool
                            </option>

                            <option value='EI Repository'>
                                EI Repository
                            </option>

                            <option value='EI SC'>
                                EI SC
                            </option>

                            <option value='EI SQA SVN Repository'>
                                EI SQA SVN Repository
                            </option>

                            <option value='EI Server 1'>
                                EI Server 1
                            </option>

                            <option value='EI Server 2'>
                                EI Server 2
                            </option>

                            <option value='EI Server 3'>
                                EI Server 3
                            </option>

                            <option value='EI Server 4'>
                                EI Server 4
                            </option>

                            <option value='EPS DB'>
                                EPS DB
                            </option>

                            <option value='EPS/ASMM Rep'>
                                EPS/ASMM Rep
                            </option>

                            <option value='ESD, SQA'>
                                ESD, SQA
                            </option>

                            <option value='ET'>
                                ET
                            </option>

                            <option value='ET '>
                                ET
                            </option>

                            <option value='ET Broker'>
                                ET Broker
                            </option>

                            <option value='ET Broker VIP'>
                                ET Broker VIP
                            </option>

                            <option value='ET Servers'>
                                ET Servers
                            </option>

                            <option value=
                            'Enterprise Integration (Enabling Tech.)'>
                                Enterprise Integration (Enabling Tech.)
                            </option>

                            <option value=
                            'Enterprise Integration (e*GATE) - schET_BROKER'>
                                Enterprise Integration (e*GATE) - schET_BROKER
                            </option>

                            <option value=
                            'Enterprise Integration (e*GATE) - schLIL_BROKER'>
                                Enterprise Integration (e*GATE) - schLIL_BROKER
                            </option>

                            <option value=
                            'Enterprise Integration (e*GATE) - schSERVICE_BROKER'>
                            Enterprise Integration (e*GATE) - schSERVICE_BROKER
                            </option>

                            <option value='FRANC Tool'>
                                FRANC Tool
                            </option>

                            <option value='FSS (Wireless, Partner Portal)'>
                                FSS (Wireless, Partner Portal)
                            </option>

                            <option value='FTP Site'>
                                FTP Site
                            </option>

                            <option value=
                            'FTP server for Performance Test documentation'>
                                FTP server for Performance Test documentation
                            </option>

                            <option value='Fairpoint Telco'>
                                Fairpoint Telco
                            </option>

                            <option value='GG (C3)'>
                                GG (C3)
                            </option>

                            <option value='Gamelounge'>
                                Gamelounge
                            </option>

                            <option value='GoldenGate'>
                                GoldenGate
                            </option>

                            <option value='Gomez Remote Machine'>
                                Gomez Remote Machine
                            </option>

                            <option value=
                            'HP Business Availability Center (BAC)'>
                                HP Business Availability Center (BAC)
                            </option>

                            <option value='HP Diagnostics'>
                                HP Diagnostics
                            </option>

                            <option value='HP ICAN'>
                                HP ICAN
                            </option>

                            <option value='HP ICAN VIP'>
                                HP ICAN VIP
                            </option>

                            <option value='HP Performance Manager'>
                                HP Performance Manager
                            </option>

                            <option value='HP Stub Server'>
                                HP Stub Server
                            </option>

                            <option value='ICAN'>
                                ICAN
                            </option>

                            <option value='ICAN (Signature Capture External)'>
                                ICAN (Signature Capture External)
                            </option>

                            <option value='ICAN (Signature Capture Internal)'>
                                ICAN (Signature Capture Internal)
                            </option>

                            <option value='ICAN (Handheld - External VIP)'>
                                ICAN (Handheld - External VIP)
                            </option>

                            <option value='ICAN (Handheld - Internal VIP)'>
                                ICAN (Handheld - Internal VIP)
                            </option>

                            <option value='ICAN (LH5)'>
                                ICAN (LH5)
                            </option>

                            <option value='ICAN (VIP)'>
                                ICAN (VIP)
                            </option>

                            <option value='ICAN Boxes'>
                                ICAN Boxes
                            </option>

                            <option value='ICAN Centralized Share'>
                                ICAN Centralized Share
                            </option>

                            <option value='ICAN Proxy'>
                                ICAN Proxy
                            </option>

                            <option value='ICAN Servers'>
                                ICAN Servers
                            </option>

                            <option value='ICAN Shares'>
                                ICAN Shares
                            </option>

                            <option value='ICAN Subnets'>
                                ICAN Subnets
                            </option>

                            <option value='ICAN VIP'>
                                ICAN VIP
                            </option>

                            <option value='ICAN WSDL Repository'>
                                ICAN WSDL Repository
                            </option>

                            <option value='ICAN WSDLs'>
                                ICAN WSDLs
                            </option>

                            <option value='IMEflex'>
                                IMEflex
                            </option>

                            <option value='ISAAC'>
                                ISAAC
                            </option>

                            <option value='IV Completion Code'>
                                IV Completion Code
                            </option>

                            <option value='IVR'>
                                IVR
                            </option>

                            <option value='IVR Servlet'>
                                IVR Servlet
                            </option>

                            <option value='IVR Servlets'>
                                IVR Servlets
                            </option>

                            <option value='IVWS'>
                                IVWS
                            </option>

                            <option value='Imperva GW'>
                                Imperva GW
                            </option>

                            <option value='Imperva Mgmt'>
                                Imperva Mgmt
                            </option>

                            <option value='Ingrian'>
                                Ingrian
                            </option>

                            <option value='Injector'>
                                Injector
                            </option>

                            <option value='Injector (Dotcom)'>
                                Injector (Dotcom)
                            </option>

                            <option value='Injector (Mobile)'>
                                Injector (Mobile)
                            </option>

                            <option value='Injectors'>
                                Injectors
                            </option>

                            <option value='Injectors (.com & C3)'>
                                Injectors (.com & C3)
                            </option>

                            <option value='JIVE'>
                                JIVE
                            </option>

                            <option value='Java Stub'>
                                Java Stub
                            </option>

                            <option value='LDAP'>
                                LDAP
                            </option>

                            <option value='LIL'>
                                LIL
                            </option>

                            <option value='LIL DB'>
                                LIL DB
                            </option>

                            <option value='LIL EJB'>
                                LIL EJB
                            </option>

                            <option value='LISA'>
                                LISA
                            </option>

                            <option value='LRDV'>
                                LRDV
                            </option>

                            <option value='LTE'>
                                LTE
                            </option>

                            <option value='M Drive'>
                                M Drive
                            </option>

                            <option value='MOSS Test Farm'>
                                MOSS Test Farm
                            </option>

                            <option value='MW Repository Page '>
                                MW Repository Page
                            </option>

                            <option value='Mail/SMTP'>
                                Mail/SMTP
                            </option>

                            <option value='NVC'>
                                NVC
                            </option>

                            <option value='Nonlinear PGWS'>
                                Nonlinear PGWS
                            </option>

                            <option value='ODS'>
                                ODS
                            </option>

                            <option value='OID'>
                                OID
                            </option>

                            <option value='OMS'>
                                OMS
                            </option>

                            <option value='OMS (QT)'>
                                OMS (QT)
                            </option>

                            <option value='OMS/OS'>
                                OMS/OS
                            </option>

                            <option value='OS'>
                                OS
                            </option>

                            <option value='OSCAR'>
                                OSCAR
                            </option>

                            <option value='PC/Collabrent'>
                                PC/Collabrent
                            </option>

                            <option value='PG Auth'>
                                PG Auth
                            </option>

                            <option value='PGWS'>
                                PGWS
                            </option>

                            <option value='PGWS (CLS)'>
                                PGWS (CLS)
                            </option>

                            <option value='PGWS (E2E)'>
                                PGWS (E2E)
                            </option>

                            <option value='PGWS (PROD)'>
                                PGWS (PROD)
                            </option>

                            <option value='PGWS Auth (E2E)'>
                                PGWS Auth (E2E)
                            </option>

                            <option value='PGWS Auth (PROD)'>
                                PGWS Auth (PROD)
                            </option>

                            <option value='PTS'>
                                PTS
                            </option>

                            <option value='Partner Portal'>
                                Partner Portal
                            </option>

                            <option value='Product Catalog'>
                                Product Catalog
                            </option>

                            <option value='QC Automation Share'>
                                QC Automation Share
                            </option>

                            <option value='QC Automation WS'>
                                QC Automation WS
                            </option>

                            <option value='QC Dev'>
                                QC Dev
                            </option>

                            <option value='QC Prod'>
                                QC Prod
                            </option>

                            <option value='QC Production'>
                                QC Production
                            </option>

                            <option value='QC Sandbox'>
                                QC Sandbox
                            </option>

                            <option value='QCDEV (Oracle DB)'>
                                QCDEV (Oracle DB)
                            </option>

                            <option value='QCPRD (Oracle DB)'>
                                QCPRD (Oracle DB)
                            </option>

                            <option value='QT WSDLs'>
                                QT WSDLs
                            </option>

                            <option value='QTP Boxes'>
                                QTP Boxes
                            </option>

                            <option value='QTP License Server'>
                                QTP License Server
                            </option>

                            <option value='RIO'>
                                RIO
                            </option>

                            <option value='RIO C3 Punch-in'>
                                RIO C3 Punch-in
                            </option>

                            <option value='RIO CC'>
                                RIO CC
                            </option>

                            <option value='RIO DB'>
                                RIO DB
                            </option>

                            <option value='RIO FSS'>
                                RIO FSS
                            </option>

                            <option value='RIO FSS Prod'>
                                RIO FSS Prod
                            </option>

                            <option value='RIO LTE Prod'>
                                RIO LTE Prod
                            </option>

                            <option value='RIO LTE Test'>
                                RIO LTE Test
                            </option>

                            <option value='RIO OOM'>
                                RIO OOM
                            </option>

                            <option value='RIO OOM '>
                                RIO OOM
                            </option>

                            <option value='RIO Partner Portal (internal)'>
                                RIO Partner Portal (internal)
                            </option>

                            <option value='RMAN'>
                                RMAN
                            </option>

                            <option value='Rio'>
                                Rio
                            </option>

                            <option value='Rio (CC AIX)'>
                                Rio (CC AIX)
                            </option>

                            <option value='Rio (FSS EAI)'>
                                Rio (FSS EAI)
                            </option>

                            <option value='Rio Actuate Reporting Server'>
                                Rio Actuate Reporting Server
                            </option>

                            <option value='Rio CC'>
                                Rio CC
                            </option>

                            <option value='Rio CC (server)'>
                                Rio CC (server)
                            </option>

                            <option value='Rio Call Center'>
                                Rio Call Center
                            </option>

                            <option value='Rio Churn Macro'>
                                Rio Churn Macro
                            </option>

                            <option value='Rio DB'>
                                Rio DB
                            </option>

                            <option value='Rio DB (Imperva Agent)'>
                                Rio DB (Imperva Agent)
                            </option>

                            <option value='Rio DB Listeners'>
                                Rio DB Listeners
                            </option>

                            <option value='Rio DB Server'>
                                Rio DB Server
                            </option>

                            <option value='Rio FSS'>
                                Rio FSS
                            </option>

                            <option value='Rio FSS (internal)'>
                                Rio FSS (internal)
                            </option>

                            <option value='Rio FSS SLA DB'>
                                Rio FSS SLA DB
                            </option>

                            <option value='Rio LDAP'>
                                Rio LDAP
                            </option>

                            <option value='Rio LDAP 631'>
                                Rio LDAP 631
                            </option>

                            <option value='Rio LTE'>
                                Rio LTE
                            </option>

                            <option value='Rio OOM'>
                                Rio OOM
                            </option>

                            <option value='Rover'>
                                Rover
                            </option>

                            <option value='Rover (now AAC)'>
                                Rover (now AAC)
                            </option>

                            <option value='SAP'>
                                SAP
                            </option>

                            <option value='SAP CRM'>
                                SAP CRM
                            </option>

                            <option value='SCM - Seebeyond Sctest-f'>
                                SCM - Seebeyond Sctest-f
                            </option>

                            <option value='SD'>
                                SD
                            </option>

                            <option value='SFDC'>
                                SFDC
                            </option>

                            <option value='SOAtest License Server'>
                                SOAtest License Server
                            </option>

                            <option value='SOAtest License Server (New)'>
                                SOAtest License Server (New)
                            </option>

                            <option value='SOAtest License Server (Old)'>
                                SOAtest License Server (Old)
                            </option>

                            <option value='SPC'>
                                SPC
                            </option>

                            <option value='SPC Web Portal'>
                                SPC Web Portal
                            </option>

                            <option value='SQA Capacity Planning App (PTS)'>
                                SQA Capacity Planning App (PTS)
                            </option>

                            <option value='STMS'>
                                STMS
                            </option>

                            <option value='STMS (R2)'>
                                STMS (R2)
                            </option>

                            <option value='Sales CRM'>
                                Sales CRM
                            </option>

                            <option value='Sales CRM LDAP for Accounts'>
                                Sales CRM LDAP for Accounts
                            </option>

                            <option value='Search PGWS'>
                                Search PGWS
                            </option>

                            <option value='Secure PGWS'>
                                Secure PGWS
                            </option>

                            <option value='SeeBeyond ET Broker'>
                                SeeBeyond ET Broker
                            </option>

                            <option value='SeeBeyond Service Broker'>
                                SeeBeyond Service Broker
                            </option>

                            <option value='Service Broker'>
                                Service Broker
                            </option>

                            <option value='Service Broker OMS'>
                                Service Broker OMS
                            </option>

                            <option value='Service Broker VIP'>
                                Service Broker VIP
                            </option>

                            <option value='Service Catalog'>
                                Service Catalog
                            </option>

                            <option value='Servlets'>
                                Servlets
                            </option>

                            <option value='Shared Injectors'>
                                Shared Injectors
                            </option>

                            <option value='Siebel CC'>
                                Siebel CC
                            </option>

                            <option value='Siebel Field Services'>
                                Siebel Field Services
                            </option>

                            <option value='Siebel Wireless'>
                                Siebel Wireless
                            </option>

                            <option value='Signal Quality'>
                                Signal Quality
                            </option>

                            <option value='Signal Strength'>
                                Signal Strength
                            </option>

                            <option value='Stub Server'>
                                Stub Server
                            </option>

                            <option value=
                            'Stub running Process Customer Assets business service'>
                            Stub running Process Customer Assets business
                            service
                            </option>

                            <option value='TAB'>
                                TAB
                            </option>

                            <option value='TAOS'>
                                TAOS
                            </option>

                            <option value='TBD'>
                                TBD
                            </option>

                            <option value='TCS'>
                                TCS
                            </option>

                            <option value='TCS (ora-tcstst)'>
                                TCS (ora-tcstst)
                            </option>

                            <option value='TLDB'>
                                TLDB
                            </option>

                            <option value='TLDB DB Node'>
                                TLDB DB Node
                            </option>

                            <option value='Target Process'>
                                Target Process
                            </option>

                            <option value='Tax Credit Adj App'>
                                Tax Credit Adj App
                            </option>

                            <option value='Tax Credit Adj App DB'>
                                Tax Credit Adj App DB
                            </option>

                            <option value='Telco'>
                                Telco
                            </option>

                            <option value='Telco/TAD'>
                                Telco/TAD
                            </option>

                            <option value='Test LDAP'>
                                Test LDAP
                            </option>

                            <option value='User Provisioning'>
                                User Provisioning
                            </option>

                            <option value='Verizon'>
                                Verizon
                            </option>

                            <option value='WOREC (ora-worectst)'>
                                WOREC (ora-worectst)
                            </option>

                            <option value='Web Admin'>
                                Web Admin
                            </option>

                            <option value='Wiki'>
                                Wiki
                            </option>

                            <option value='Wireless Test App (Engr)'>
                                Wireless Test App (Engr)
                            </option>

                            <option value='XML Dump'>
                                XML Dump
                            </option>

                            <option value='XML Dump (QT)'>
                                XML Dump (QT)
                            </option>

                            <option value='ZLDS'>
                                ZLDS
                            </option>

                            <option value='adapt.directv.com'>
                                adapt.directv.com
                            </option>

                            <option value='clarity.directv.com'>
                                clarity.directv.com
                            </option>

                            <option value='com-fusion'>
                                com-fusion
                            </option>

                            <option value='contentpreview.directv.com'>
                                contentpreview.directv.com
                            </option>

                            <option value='contentstaging.directv.com'>
                                contentstaging.directv.com
                            </option>

                            <option value='d4appa08.la.frd.directv.com'>
                                d4appa08.la.frd.directv.com
                            </option>

                            <option value='dtvint.directv.com'>
                                dtvint.directv.com
                            </option>

                            <option value='dtvint2.directv.com'>
                                dtvint2.directv.com
                            </option>

                            <option value='dtvperf.directv.com'>
                                dtvperf.directv.com
                            </option>

                            <option value='dtvstage.directv.com'>
                                dtvstage.directv.com
                            </option>

                            <option value='eGate'>
                                eGate
                            </option>

                            <option value='eGate LIL'>
                                eGate LIL
                            </option>

                            <option value='eGate Test Tool'>
                                eGate Test Tool
                            </option>

                            <option value='ePlan'>
                                ePlan
                            </option>

                            <option value='ePlan Sandbox'>
                                ePlan Sandbox
                            </option>

                            <option value='eTrust'>
                                eTrust
                            </option>

                            <option value='edapt.directv.com'>
                                edapt.directv.com
                            </option>

                            <option value=
                            'https://portal.rio.r5.directv.com/echannelcmesm_enu'>
                            https://portal.rio.r5.directv.com/echannelcmesm_enu
                            </option>

                            <option value=
                            'https://wls.rio.r5.directv.com/wireless'>
                                https://wls.rio.r5.directv.com/wireless
                            </option>

                            <option value='iTKO LISA VSE Host'>
                                iTKO LISA VSE Host
                            </option>

                            <option value='logs in dtvint '>
                                logs in dtvint
                            </option>

                            <option value='logs in dtvint2 '>
                                logs in dtvint2
                            </option>

                            <option value='mptest.directv.com'>
                                mptest.directv.com
                            </option>

                            <option value='mwproxy.directv.com'>
                                mwproxy.directv.com
                            </option>

                            <option value='mwproxyint.directv.com'>
                                mwproxyint.directv.com
                            </option>

                            <option value='mwproxystg.directv.com'>
                                mwproxystg.directv.com
                            </option>

                            <option value='portal.rio.directv.com'>
                                portal.rio.directv.com
                            </option>

                            <option value='servlets'>
                                servlets
                            </option>

                            <option value='sqa'>
                                sqa
                            </option>

                            <option value='test.directvoms.intergies.com'>
                                test.directvoms.intergies.com
                            </option>

                            <option value='webadmintest.directv.com'>
                                webadmintest.directv.com
                            </option>
                        </select><br>
                        <b>Order:</b><br>
                        <select name="Order">
                            <option value='environment'>
                                environment
                            </option>

                            <option value='type'>
                                type
                            </option>

                            <option value='sourceLocation'>
                                sourceLocation
                            </option>

                            <option value='source'>
                                source
                            </option>

                            <option value='sourceIP'>
                                sourceIP
                            </option>

                            <option value='destination'>
                                destination
                            </option>

                            <option value='destinationLocation'>
                                destinationLocation
                            </option>

                            <option value='destinationIP'>
                                destinationIP
                            </option>

                            <option value='destinationPort'>
                                destinationPort
                            </option>

                            <option value='protocol'>
                                protocol
                            </option>

                            <option value='URL'>
                                URL
                            </option>

                            <option value='note'>
                                note
                            </option>
                        </select><br></td>
                    </tr>
                </table><input name="submit" type="submit" value=
                "Search Records"> <button onclick=
                "window.open('/networkflows/SQANetworkFlows.php', '_self')"
                type="button">Clear Search</button> <button onclick=
                "window.open('/networkflows/deleted.php', '_self')" type=
                "button">Deleted Records</button>
            </form>
        </div>

        <div id='results'>
            <h3>Query Results:</h3>Total rows returned: <b>1</b><br>
            Your search query: <b>SELECT * FROM networkflows LIMIT 1</b><br>

            <form action="/networkflows/newform.php" method="post">
                <input name="add" type="submit" value="Add New Entry">
            </form>

            <table border='1' cellspacing='2'>
                <tr>
                    <th></th>

                    <th>Row#</th>

                    <th>environment</th>

                    <th>type</th>

                    <th>sourceLocation</th>

                    <th>source</th>

                    <th>sourceIP</th>

                    <th>destination</th>

                    <th>destinationLocation</th>

                    <th>destinationIP</th>

                    <th>destinationPort</th>

                    <th>protocol</th>

                    <th>URL</th>

                    <th>note</th>
                </tr>

                <tr>
                    <td>
                        <form action='/networkflows/newform.php' method='post'>
                            <div id='noDisplay'>
                                <input name='environmentCopy' type='textbox'
                                value="Dev"> <input name='typeCopy' type=
                                'textbox' value="Tester"> <input name=
                                'sourceLocationCopy' type='textbox' value=
                                "IBM Brazil"> <input name='sourceCopy' type=
                                'textbox' value="SQA Testers"> <input name=
                                'sourceIPCopy' type='textbox' value=
                                "158.98.171.0/24"> <input name=
                                'destinationCopy' type='textbox' value=
                                "C3 D1A"> <input name='destinationLocationCopy'
                                type='textbox' value="LADC"> <input name=
                                'destinationIPCopy' type='textbox' value=
                                "147.22.252.1"> <input name=
                                'destinationPortCopy' type='textbox' value=
                                "81"> <input name='protocolCopy' type='textbox'
                                value="TCP"> <input name='URLCopy' type=
                                'textbox' value=""> <input name='noteCopy'
                                type='textbox' value="SDR 1175162">
                            </div><input name="copy" type="submit" value=
                            "Copy Record"> <input name="edit" type="submit"
                            value="Edit Record">
                        </form>

                        <form action='/networkflows/deleteform.php' method=
                        'post'>
                            <div id='noDisplay'>
                                <input name='environmentDelete' type='textbox'
                                value="Dev"> <input name='typeDelete' type=
                                'textbox' value="Tester"> <input name=
                                'sourceLocationDelete' type='textbox' value=
                                "IBM Brazil"> <input name='sourceDelete' type=
                                'textbox' value="SQA Testers"> <input name=
                                'sourceIPDelete' type='textbox' value=
                                "158.98.171.0/24"> <input name=
                                'destinationDelete' type='textbox' value=
                                "C3 D1A"> <input name=
                                'destinationLocationDelete' type='textbox'
                                value="LADC"> <input name='destinationIPDelete'
                                type='textbox' value="147.22.252.1">
                                <input name='destinationPortDelete' type=
                                'textbox' value="81"> <input name=
                                'protocolDelete' type='textbox' value="TCP">
                                <input name='URLDelete' type='textbox' value=
                                ""> <input name='noteDelete' type='textbox'
                                value="SDR 1175162">
                            </div><input name="delete" type="submit" value=
                            "Delete Record">
                        </form>
                    </td>

                    <td>1</td>

                    <td>Dev</td>

                    <td>Tester</td>

                    <td>IBM Brazil</td>

                    <td>SQA Testers</td>

                    <td>158.98.171.0/24</td>

                    <td>C3 D1A</td>

                    <td>LADC</td>

                    <td>147.22.252.1</td>

                    <td>81</td>

                    <td>TCP</td>

                    <td></td>

                    <td>SDR 1175162</td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
