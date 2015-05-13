<?php
$testSQL = "
SELECT
    IFNULL(hostip, 'TOTAL') as Server,
    SUM(CASE WHEN status='running' THEN 1 ELSE 0 END) AS 'Running',
    SUM(CASE WHEN status='loaded' THEN 1 ELSE 0 END) AS 'Loaded',
    SUM(CASE WHEN status='down' THEN 1 ELSE 0 END) AS 'Down',
    count(serviceName) as '$beginDate'
FROM
    log
GROUP BY
    hostip WITH ROLLUP;
";


$tdmSQL ="
SELECT A.AREACODE + A.'NUMBER' AS WTN,
    OM.ACCTNUM AS DBSCustomer_Account_No,
    O.ORDERID AS DBSOrder_ID,
    AD.FIRSTNAME AS 'First Name',
    AD.LASTNAME AS 'Last Name',
    AD.STREET1 AS Address_Line1,
    COALESCE(AD.STREET2 + ' ' + AD.APTNUM, '') AS Address_Line2,
    AD.CITY AS City,
    AD.STATE AS STATE,
    SUBSTRING(AD.ZIP, 1, 5) + '-' + CASE SUBSTRING(AD.ZIP, 6, 4)
        WHEN ''
            THEN '0000'
        END AS Zip,
    'ORDR' AS Order_Status,
    CONVERT(VARCHAR(30), O.ORDERDATE, 120) AS Transaction_Date,
    O.DNIS AS Marketing_Source_Code,
    DL.ACCTTYPE AS 'AccountType',
    TEMP5.SALESAGENTID AS Sales_Agent_ID,
    UPPER(E.AGENTID) AS GUI_Login_ID,
    DL.DEALERCODE AS Dealer_ID,
    '' AS Cancel_Reason_Code,
    '' AS Cancel_Reason_Description,
    '' AS Cancel_Source,
    ISNULL(SUBSTRING(SRVCS.SOURCEORDERID, 1, 20), '') AS Source_System_Order_ID,
    CASE (SUBSTRING(SRVCS.DSVCCODE, 1, 1) + CONVERT(VARCHAR(8), CONVERT(INT, SUBSTRING(SRVCS.DSVCCODE, 2, 9))))
        WHEN 'T1'
            THEN ''
        ELSE (SUBSTRING(SRVCS.DSVCCODE, 1, 1) + CONVERT(VARCHAR(8), CONVERT(INT, SUBSTRING(SRVCS.DSVCCODE, 2, 9))))
        END AS Service_Codes,
    ISNULL(SRVCS.HARDWARE_PRODUCTTYPE, '') AS HARDWARE_ProductType,
    COALESCE(CASE (SRVCS.PRODUCTCLASS)
            WHEN 'ADVANCED'
                THEN 'Advanced'
            ELSE (SRVCS.PRODUCTCLASS)
            END, '') AS ProductClass,
    ISNULL(TEMP4.ATTBAN, '') AS ATT_Billing_Account_Number,
    '' AS ATT_User_ID,
    COALESCE(TEMP.JOINTBILLFLAG, '') AS Joint_Billed_Indicator,
    COALESCE(TEMP1.ATT_SALES_CHANNEL, '') AS ATT_Sales_Channel,
    COALESCE(TEMP2.ANCHORACCTTYPE, '') AS Anchor_Account_Type
FROM FULLMSD.DBO.OMSMAP OM(NOLOCK)
INNER JOIN DIRECTVDS.DBO.ORDERS O(NOLOCK)
    ON OM.CUSTID = O.CUSTID
INNER JOIN DIRECTVDS.DBO.CUSTADDRESSES AD
    ON OM.CUSTID = AD.CUSTID
INNER JOIN DIRECTVDS.DBO.SVCADDRESSES A
    ON A.ORDERID = O.ORDERID
INNER JOIN DIRECTVDS.DBO.DEALERIDS DL
    ON O.DEALERID = DL.DEALERID
INNER JOIN DIRECTVDS.DBO.EVENTS E
    ON E.EVENTID = O.EVENTID
LEFT JOIN (
    SELECT EC1.EVENTID,
        EC1.'VALUE' AS JOINTBILLFLAG
    FROM DIRECTVDS.DBO.EVENTCUSTOMDATA EC1
    INNER JOIN DIRECTVDS.DBO.CUSTOMDATANAMES CD1
        ON (EC1.CUSTOMDATANAMEID = CD1.CUSTOMDATANAMEID)
    WHERE CD1.NAME = 'JOINTBILLEDFLAG'
    ) TEMP
    ON (TEMP.EVENTID = E.EVENTID)
LEFT JOIN (
    SELECT EC6.EVENTID,
        EC6.'VALUE' AS SALESAGENTID
    FROM DIRECTVDS.DBO.EVENTCUSTOMDATA EC6
    INNER JOIN DIRECTVDS.DBO.CUSTOMDATANAMES CD6
        ON (EC6.CUSTOMDATANAMEID = CD6.CUSTOMDATANAMEID)
    WHERE CD6.NAME = 'SALESAGENTID'
    ) TEMP5
    ON (TEMP5.EVENTID = O.EVENTID)
LEFT JOIN (
    SELECT EC2.EVENTID,
        EC2.'VALUE' AS ATT_SALES_CHANNEL
    FROM DIRECTVDS.DBO.EVENTCUSTOMDATA EC2
    INNER JOIN DIRECTVDS.DBO.CUSTOMDATANAMES CD2
        ON (EC2.CUSTOMDATANAMEID = CD2.CUSTOMDATANAMEID)
    WHERE CD2.NAME = 'SALESCHANNELINDICATOR'
    ) TEMP1
    ON (TEMP1.EVENTID = E.EVENTID)
LEFT JOIN (
    SELECT EC3.EVENTID,
        EC3.'VALUE' AS ANCHORACCTTYPE
    FROM DIRECTVDS.DBO.EVENTCUSTOMDATA EC3
    INNER JOIN DIRECTVDS.DBO.CUSTOMDATANAMES CD3
        ON (EC3.CUSTOMDATANAMEID = CD3.CUSTOMDATANAMEID)
    WHERE CD3.NAME = 'PARTNERASSOCIATEDACCOUNTTYPE'
    ) TEMP2
    ON (TEMP2.EVENTID = E.EVENTID)
LEFT JOIN (
    SELECT EC5.EVENTID,
        EC5.'VALUE' AS ATTBAN
    FROM DIRECTVDS.DBO.EVENTCUSTOMDATA EC5
    INNER JOIN DIRECTVDS.DBO.CUSTOMDATANAMES CD5
        ON (EC5.CUSTOMDATANAMEID = CD5.CUSTOMDATANAMEID)
    WHERE CD5.NAME = 'PARTNERACCOUNTID'
    ) TEMP4
    ON (TEMP4.EVENTID = E.EVENTID)
LEFT JOIN (
    SELECT EC6.EVENTID,
        EC6.'VALUE' AS ATTUID
    FROM DIRECTVDS.DBO.EVENTCUSTOMDATA EC6
    INNER JOIN DIRECTVDS.DBO.CUSTOMDATANAMES CD6
        ON (EC6.CUSTOMDATANAMEID = CD6.CUSTOMDATANAMEID)
    WHERE CD6.NAME = 'SALESAGENTID'
    ) TEMP6
    ON (TEMP6.EVENTID = E.EVENTID)
LEFT JOIN (
    SELECT OM.ACCTNUM,
        O.EVENTID,
        O.ORDERID,
        O.ORDERDATE,
        SR.SOURCEORDERID,
        SC.DSVCCODE,
        (
            CASE
                WHEN SC.DSVCCODE IS NOT NULL
                    AND SC.DSVCCODE <> ''
                    AND PT.IRDTYPE IS NULL
                    THEN NULL
                WHEN SC.DSVCCODE IS NOT NULL
                    AND SC.DSVCCODE = ''
                    AND PT.IRDTYPE IS NULL
                    AND P.PRODUCTDESC = 'INTERNET CONNECTION KIT (COAX)'
                    THEN 'COAX'
                WHEN SC.DSVCCODE IS NOT NULL
                    AND SC.DSVCCODE = ''
                    AND PT.IRDTYPE IS NULL
                    AND ODN.CUSTOMVALUE = 'DIRECTV CLIENT'
                    THEN 'DIRECTV CLIENT'
                WHEN SC.DSVCCODE IS NOT NULL
                    AND SC.DSVCCODE = ''
                    AND PT.IRDTYPE IS NULL
                    AND P.SFSPRODUCTLINE = 'SHARED CONTENT DEVICE'
                    THEN 'GENIEGO'
                ELSE (
                        CASE
                            WHEN PT.IRDTYPE IN ('A', 'HR')
                                THEN 'HDDVR'
                            WHEN PT.IRDTYPE IN ('H', 'IH', 'H2')
                                THEN 'HD'
                            WHEN PT.IRDTYPE IN ('D1', 'D2', 'D3', 'D4')
                                THEN 'DVR'
                            WHEN PT.IRDTYPE IN ('S')
                                THEN 'STANDARD'
                            WHEN PT.IRDTYPE IN ('HS')
                                THEN 'HMC'
                            ELSE ''
                            END
                        )
                END
            ) AS HARDWARE_PRODUCTTYPE,
        (
            CASE
                WHEN PT.IRDTYPE IN ('A', 'HR', 'H', 'IH', 'H2', 'D1', 'D2', 'D3', 'D4', 'HS')
                    THEN 'ADVANCED'
                WHEN PT.IRDTYPE IN ('S')
                    THEN 'STANDARD'
                WHEN P.PRODUCTDESC = 'INTERNET CONNECTION KIT (COAX)'
                    THEN 'MISC'
                WHEN ODN.CUSTOMVALUE = 'DIRECTV CLIENT'
                    THEN 'MISC'
                WHEN P.SFSPRODUCTLINE = 'SHARED CONTENT DEVICE'
                    THEN 'MISC'
                ELSE ''
                END
            ) AS PRODUCTCLASS
    FROM FULLMSD.DBO.OMSMAP OM(NOLOCK)
    INNER JOIN DIRECTVDS.DBO.ORDERS O(NOLOCK)
        ON OM.CUSTID = O.CUSTID
    INNER JOIN DIRECTVDS.DBO.EVENTS E
        ON E.EVENTID = O.EVENTID
    INNER JOIN DIRECTVDS.DBO.ORDERDETAILS OD
        ON O.ORDERID = OD.ORDERID
    LEFT JOIN DIRECTVDS.DBO.SOURCESYSMAP SR
        ON SR.DETAILID = OD.DETAILID
    INNER JOIN DIRECTVDS.DBO.PRODUCTS P
        ON P.PRODUCTID = OD.PRODUCTID
    INNER JOIN DIRECTVDS.DBO.PRODUCTTYPES PT
        ON P.PRODUCTTYPEID = PT.PRODUCTTYPEID
    LEFT JOIN DIRECTVDS.DBO.SERVICECODES SC
        ON (SC.SERVICECODEID = P.SERVICECODEID)
    LEFT JOIN DIRECTVDS.DBO.ORDERDETAILCUSTOMDATA ODN
        ON ODN.DETAILID = OD.DETAILID
    WHERE 1 = 1
        AND (
            SR.SOURCEORDERID IS NULL
            OR NOT (
                SR.SOURCEORDERID LIKE '%^_%' ESCAPE '^'
                AND (
                    (
                        SUBSTRING(SR.SOURCEORDERID, 1, 1) LIKE '%1%'
                        OR SUBSTRING(SR.SOURCEORDERID, 1, 1) LIKE '%2%'
                        OR SUBSTRING(SR.SOURCEORDERID, 1, 1) LIKE '%3%'
                        OR SUBSTRING(SR.SOURCEORDERID, 1, 1) LIKE '%4%'
                        OR SUBSTRING(SR.SOURCEORDERID, 1, 1) LIKE '%5%'
                        OR SUBSTRING(SR.SOURCEORDERID, 1, 1) LIKE '%6%'
                        OR SUBSTRING(SR.SOURCEORDERID, 1, 1) LIKE '%7%'
                        OR SUBSTRING(SR.SOURCEORDERID, 1, 1) LIKE '%8%'
                        OR SUBSTRING(SR.SOURCEORDERID, 1, 1) LIKE '%9%'
                        OR SUBSTRING(SR.SOURCEORDERID, 1, 1) LIKE '%0%'
                        )
                    OR (
                        SUBSTRING(SR.SOURCEORDERID, 2, 1) LIKE '%1%'
                        OR SUBSTRING(SR.SOURCEORDERID, 2, 1) LIKE '%2%'
                        OR SUBSTRING(SR.SOURCEORDERID, 2, 1) LIKE '%3%'
                        OR SUBSTRING(SR.SOURCEORDERID, 2, 1) LIKE '%4%'
                        OR SUBSTRING(SR.SOURCEORDERID, 2, 1) LIKE '%5%'
                        OR SUBSTRING(SR.SOURCEORDERID, 2, 1) LIKE '%6%'
                        OR SUBSTRING(SR.SOURCEORDERID, 2, 1) LIKE '%7%'
                        OR SUBSTRING(SR.SOURCEORDERID, 2, 1) LIKE '%8%'
                        OR SUBSTRING(SR.SOURCEORDERID, 2, 1) LIKE '%9%'
                        OR SUBSTRING(SR.SOURCEORDERID, 2, 1) LIKE '%0%'
                        )
                    )
                )
            )
        AND O.ORDERDATE >= CONVERT(DATETIME, CONVERT(VARCHAR(10), GETDATE() - $beginDate, 111))
        AND O.DNIS IN ('7110', '7111', '7112', '7114', '7115')
        AND OM.ACCTNUM > 1
        AND O.ORDERID IN ($orderID)
        AND DSVCCODE IS NOT NULL
        AND OD.DETAILID NOT IN (
            SELECT CDD.DETAILID
            FROM DIRECTVDS.DBO.CANCELEDDETAILS CDD
            WHERE CDD.DETAILID = OD.DETAILID
                AND CDD.DETAILID <> 0
            )
        AND (
            (
                (
                    ISSERVICE = 1
                    OR ISIRD = 1
                    )
                AND PT.PRODUCTTYPE <> 'REBATE'
                AND ISANTENNA <> 1 /* TO EXCLUDE DISH  */
                )
            OR P.PRODUCTDESC = 'INTERNET CONNECTION KIT (COAX)'
            )
    ) SRVCS
    ON (
            SRVCS.ACCTNUM = OM.ACCTNUM
            AND O.ORDERID = SRVCS.ORDERID
            AND O.ORDERDATE = SRVCS.ORDERDATE
            )
WHERE 1 = 1
    AND O.ORDERID IN ($orderID)
    AND O.ORDERDATE >= CONVERT(DATETIME, CONVERT(VARCHAR(10), GETDATE() - $beginDate, 111))
    AND O.DNIS IN ('7110', '7111', '7112', '7114', '7115')
    AND OM.ACCTNUM > 1
ORDER BY OM.ACCTNUM,
    Service_Codes
";

?>
