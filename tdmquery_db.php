<?php
    include_once("db_connection.php");
    $acctNum    = $_POST['acctNum'];    # line 165, 179
    $beginDate  = $_POST['beginDate'];  # line 161, 180
    $endDate    = $_POST['endDate'];    # line 162, 181

    $totalSQL = "
    SELECT
        IFNULL(hostip, 'TOTAL') as Server,
        SUM(CASE WHEN status='running' THEN 1 ELSE 0 END) AS 'Running',
        SUM(CASE WHEN status='loaded' THEN 1 ELSE 0 END) AS 'Loaded',
        SUM(CASE WHEN status='down' THEN 1 ELSE 0 END) AS 'Down',
        count(serviceName) as '$beginDate'
    FROM
        log
    GROUP BY
        hostip WITH ROLLUP;";

    $tdmSQL = "
    SELECT DISTINCT A.areacode + A.\"number\" AS WTN,
                    OM.acctnum,
                    O.orderid,
                    AD.firstname,
                    AD.lastname,
                    AD.street1,
                    AD.street2,
                    AD.city,
                    AD.state,
                    AD.zip,
                    'ORDR',
                    O.orderdate,
                    O.dnis,
                    DL.accttype,
                    TEMP5.salesagentid,
                    Upper(E.agentid)        AS GUI_LOGIN_ID,
                    DL.dealercode,
                    TEMP.jointbillflag,
                    P2.answer               AS ATTBAN,
                    P3.answer               AS ATTUID,
                    TEMP1.att_sales_channel,
                    TEMP2.anchoraccttype,
                    SRVCS.dsvccode,
                    Substring(SRVCS.dsvccode, 1, 1),
                    CONVERT(INTEGER, Substring(SRVCS.dsvccode, 2, 9)),
                    SRVCS.hardware_producttype,
                    SRVCS.productclass,
                    SRVCS.sourceorderid
    FROM   fullmsd.dbo.omsmap OM ( nolock )
           INNER JOIN directvds.dbo.orders O ( nolock )
                   ON OM.custid = O.custid
           INNER JOIN directvds.dbo.custaddresses AD
                   ON OM.custid = AD.custid
           INNER JOIN directvds.dbo.svcaddresses A
                   ON A.orderid = O.orderid
           INNER JOIN directvds.dbo.dealerids DL
                   ON O.dealerid = DL.dealerid
           INNER JOIN directvds.dbo.events E
                   ON E.eventid = O.eventid
           INNER JOIN directvds.dbo.orderdetails OD
                   ON O.orderid = OD.orderid
           INNER JOIN directvds.dbo.products P
                   ON P.productid = OD.productid
           INNER JOIN directvds.dbo.producttypes PT
                   ON P.producttypeid = PT.producttypeid
           LEFT JOIN directvds.dbo.parm_capture P2
                  ON P2.eventid = O.eventid
                     AND P2.parm_nm = 'ATT BILLING ACCOUNT'
           LEFT JOIN directvds.dbo.parm_capture P3
                  ON P3.eventid = O.eventid
                     AND P3.parm_nm = 'ATT UID'
           LEFT JOIN (SELECT EC1.eventid,
                             EC1.\"value\" AS JOINTBILLFLAG
                      FROM   directvds.dbo.eventcustomdata EC1
                             JOIN directvds.dbo.customdatanames CD1
                               ON ( EC1.customdatanameid = CD1.customdatanameid )
                      WHERE  CD1.NAME = 'JOINTBILLEDFLAG') TEMP
                  ON ( TEMP.eventid = E.eventid )
           LEFT JOIN (SELECT EC6.eventid,
                             EC6.\"value\" AS SALESAGENTID
                      FROM   directvds.dbo.eventcustomdata EC6
                             JOIN directvds.dbo.customdatanames CD6
                               ON ( EC6.customdatanameid = CD6.customdatanameid )
                      WHERE  CD6.NAME = 'SALESAGENTID') TEMP5
                  ON ( TEMP5.eventid = O.eventid )
           LEFT JOIN (SELECT EC2.eventid,
                             EC2.\"value\" AS ATT_SALES_CHANNEL
                      FROM   directvds.dbo.eventcustomdata EC2
                             JOIN directvds.dbo.customdatanames CD2
                               ON ( EC2.customdatanameid = CD2.customdatanameid )
                      WHERE  CD2.NAME = 'SALESCHANNELINDICATOR') TEMP1
                  ON ( TEMP1.eventid = E.eventid )
           LEFT JOIN (SELECT EC3.eventid,
                             EC3.\"value\" AS ANCHORACCTTYPE
                      FROM   directvds.dbo.eventcustomdata EC3
                             JOIN directvds.dbo.customdatanames CD3
                               ON ( EC3.customdatanameid = CD3.customdatanameid )
                      WHERE  CD3.NAME = 'PARTNERASSOCIATEDACCOUNTTYPE') TEMP2
                  ON ( TEMP2.eventid = E.eventid )
           INNER JOIN (SELECT DISTINCT OM.acctnum,
                                       O.eventid,
                                       O.orderid,
                                       O.orderdate,
                                       SR.sourceorderid,
                                       SC.dsvccode,
                                       ( CASE
                                           WHEN SC.dsvccode IS NOT NULL
                                                AND SC.dsvccode <> ''
                                                AND PT.irdtype IS NULL THEN NULL
                                           WHEN SC.dsvccode IS NOT NULL
                                                AND SC.dsvccode = ''
                                                AND PT.irdtype IS NULL
                                                AND P.productdesc = 'INTERNET CONNECTION KIT (COAX)' THEN 'COAX'
                                           WHEN SC.dsvccode IS NOT NULL
                                                AND SC.dsvccode = ''
                                                AND PT.irdtype IS NULL
                                                AND ODN.customvalue = 'DIRECTV CLIENT' THEN 'DIRECTV CLIENT'
                                           WHEN SC.dsvccode IS NOT NULL
                                                AND SC.dsvccode = ''
                                                AND PT.irdtype IS NULL
                                                AND P.sfsproductline = 'SHARED CONTENT DEVICE' THEN 'GENIEGO'
                                           ELSE ( CASE
                                                    WHEN PT.irdtype IN ( 'A', 'HR' ) THEN 'HDDVR'
                                                    WHEN PT.irdtype IN ( 'H', 'IH', 'H2' ) THEN 'HD'
                                                    WHEN PT.irdtype IN ( 'D1', 'D2', 'D3', 'D4' ) THEN 'DVR'
                                                    WHEN PT.irdtype IN ( 'S' ) THEN 'STANDARD'
                                                    WHEN PT.irdtype IN ( 'HS' ) THEN 'HMC'
                                                    ELSE ''
                                                  END )
                                         END ) AS HARDWARE_PRODUCTTYPE,
                                       ( CASE
                                           WHEN PT.irdtype IN ( 'A', 'HR', 'H', 'IH',
                                                                'H2', 'D1', 'D2', 'D3',
                                                                'D4', 'HS' ) THEN 'ADVANCED'
                                           WHEN PT.irdtype IN ( 'S' ) THEN 'STANDARD'
                                           WHEN P.productdesc = 'INTERNET CONNECTION KIT (COAX)' THEN 'MISC'
                                           WHEN ODN.customvalue = 'DIRECTV CLIENT' THEN 'MISC'
                                           WHEN P.sfsproductline = 'SHARED CONTENT DEVICE' THEN 'MISC'
                                           ELSE ''
                                         END ) AS PRODUCTCLASS
                       FROM   fullmsd.dbo.omsmap OM ( nolock )
                              INNER JOIN directvds.dbo.orders O ( nolock )
                                      ON OM.custid = O.custid
                              INNER JOIN directvds.dbo.events E
                                      ON E.eventid = O.eventid
                              INNER JOIN directvds.dbo.orderdetails OD
                                      ON O.orderid = OD.orderid
                              LEFT JOIN directvds.dbo.sourcesysmap SR
                                     ON SR.detailid = OD.detailid
                              INNER JOIN directvds.dbo.products P
                                      ON P.productid = OD.productid
                              INNER JOIN directvds.dbo.producttypes PT
                                      ON P.producttypeid = PT.producttypeid
                              LEFT JOIN directvds.dbo.servicecodes SC
                                     ON ( SC.servicecodeid = P.servicecodeid )
                              LEFT JOIN directvds.dbo.orderdetailcustomdata ODN
                                     ON ODN.detailid = OD.detailid
                       WHERE  1 = 1
                              AND ( SR.sourceorderid IS NULL
                                     OR NOT( SR.sourceorderid LIKE '%^_%' ESCAPE '^'
                                             AND ( ( Substring(SR.sourceorderid, 1, 1) LIKE '%1%'
                                                      OR Substring(SR.sourceorderid, 1, 1) LIKE '%2%'
                                                      OR Substring(SR.sourceorderid, 1, 1) LIKE '%3%'
                                                      OR Substring(SR.sourceorderid, 1, 1) LIKE '%4%'
                                                      OR Substring(SR.sourceorderid, 1, 1) LIKE '%5%'
                                                      OR Substring(SR.sourceorderid, 1, 1) LIKE '%6%'
                                                      OR Substring(SR.sourceorderid, 1, 1) LIKE '%7%'
                                                      OR Substring(SR.sourceorderid, 1, 1) LIKE '%8%'
                                                      OR Substring(SR.sourceorderid, 1, 1) LIKE '%9%'
                                                      OR Substring(SR.sourceorderid, 1, 1) LIKE '%0%' )
                                                    OR ( Substring(SR.sourceorderid, 2, 1) LIKE '%1%'
                                                          OR Substring(SR.sourceorderid, 2, 1) LIKE '%2%'
                                                          OR Substring(SR.sourceorderid, 2, 1) LIKE '%3%'
                                                          OR Substring(SR.sourceorderid, 2, 1) LIKE '%4%'
                                                          OR Substring(SR.sourceorderid, 2, 1) LIKE '%5%'
                                                          OR Substring(SR.sourceorderid, 2, 1) LIKE '%6%'
                                                          OR Substring(SR.sourceorderid, 2, 1) LIKE '%7%'
                                                          OR Substring(SR.sourceorderid, 2, 1) LIKE '%8%'
                                                          OR Substring(SR.sourceorderid, 2, 1) LIKE '%9%'
                                                          OR Substring(SR.sourceorderid, 2, 1) LIKE '%0%' ) ) ) )
                              AND O.orderdate >= CONVERT(DATETIME, CONVERT(VARCHAR(10), Getdate() - '$beginDate', 111))
                              AND O.orderdate < CONVERT(DATETIME, CONVERT(VARCHAR(10), Getdate() - '$endDate', 111))
                              AND O.dnis IN ( '7110', '7111', '7112', '7114', '7115' )
                              AND OM.acctnum > 1
                              AND OM.acctnum IN ( $acctNum )
                              AND dsvccode IS NOT NULL
                              AND OD.detailid NOT IN (SELECT CDD.detailid
                                                      FROM   directvds.dbo.canceleddetails CDD
                                                      WHERE  CDD.detailid = OD.detailid
                                                             AND CDD.detailid <> 0)
                              AND ( ( ( isservice = 1
                                         OR isird = 1 )
                                      AND PT.producttype <> 'REBATE'
                                      AND isantenna <> 1/* TO EXCLUDE DISH */ )
                                     OR P.productdesc = 'INTERNET CONNECTION KIT (COAX)' )) SRVCS
                   ON ( SRVCS.acctnum = OM.acctnum
                        AND O.orderid = SRVCS.orderid )
    WHERE  1 = 1
           AND OM.acctnum IN ( $acctNum )
           AND O.orderdate >= CONVERT(DATETIME, CONVERT(VARCHAR(10), Getdate() - '$beginDate', 111))
           AND O.orderdate < CONVERT(DATETIME, CONVERT(VARCHAR(10), Getdate() - '$endDate', 111))
           AND O.dnis IN ( '7110', '7111', '7112', '7114', '7115' )
           AND OM.acctnum > 1;
    ";

    # Print query

    $tdmArray = explode("\n", $tdmSQL); # Break query into array
    # Remove lines from query if form is left blank
    foreach ($tdmArray as $key => $line) {
        if ( empty($beginDate) && stripos("$line", "orderdate >=") !== false) {
            # echo "Removing: $line at $key<br />";
            unset($tdmArray[$key]);
        }
        if ( empty($endDate) && stripos("$line", "orderdate <") !== false) {
            # echo "Removing: $line at $key<br />";
            unset($tdmArray[$key]);
        }
        if ( empty($acctNum) && stripos("$line", "acctnum IN") !== false) {
            # echo "Removing: $line at $key<br />";
            unset($tdmArray[$key]);
        }
    }
    $tdmSQLFiltered = implode("\n", $tdmArray);
    #echo "<pre>Filtered: $tdmSQLFiltered\n</pre>";
    $result = mysqli_query($con, "$totalSQL") or die(mysqli_error);
    $headers = [];
    $i = 0;
    while($nameField = mysqli_fetch_field($result)){
        $headers[$i] = $nameField->name;
        $i++;
    }
    // $fileName = 'query_output.txt';
    //
    // header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    // header('Content-Description: File Transfer');
    // header("Content-type: text/plain");
    // header("Content-Disposition: attachment; filename={$fileName}");
    // header("Expires: 0");
    // header("Pragma: public");
    // $fh = @fopen( 'php://output', 'w' );
    // $headerDisplayed = false;
    // fwrite($fh, "$tdmSQLFiltered");
    // fclose($fh);
    // exit;

    $num_fields = mysqli_num_fields($result);

    $fp = fopen('php://output', 'w');
    if ($fp && $result) {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="export.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');
        fputcsv($fp, $headers);
        while ($row = $result->fetch_array(MYSQLI_NUM)) {
            fputcsv($fp, array_values($row));
        }
        die;
    }
    # Display result as table
    echo "Results:";

    /*
    echo "<table id='results'>";
        echo "<thead>";
            echo "<tr>";
                foreach ($columnNameArr as $colName){
                    echo "<th>$colName</th>";
                }
            echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
            foreach ($totalResult as $row){
                echo "<tr>";
                foreach ($row as $col){
                    echo "<td>$col</td>";
                }
                echo "</tr>";
            }
        echo "</tbody>";
    echo "</table>"; */
?>
