<?php
    session_start();
    $rows = $_SESSION['rows'];
    $headers = $_SESSION['headers'];

    # Convert result to csv and push use to download if user pressed "Download" button
    if(isset($_POST["downloadquery"])) {
        $fp = fopen('php://output', 'w');
        ob_start();
        if ($fp && $rows) {
            # fputcsv($fp, $headers); # populate header csv format
            $joinedHeader = implode("|", $headers);
            fwrite($fp, "$joinedHeader\n");
            foreach ($rows as $row) {
                #fputcsv($fp, array_values($row)); #populate rows csv format
                $joinedRow = implode("|", $row);
                fwrite($fp, "$joinedRow\n");
            }
        }
        $content = ob_get_clean();
        $filename ='tdmQueryResult_' . date('Ymd');

        // Output CSV-specific headers
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private', false);
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $filename . '.txt";');

        exit($content);
    }
?>
