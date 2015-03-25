<!DOCTYPE html>
<html>
<head>
    <title>LISA Catalog</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</head>
<body>
    <table id='test' width="100%" border="0" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th>MY HEADER</th>
                <th>MY HEADER</th>
                <th>MY HEADER</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>COL</td>
                <td>COL</td>
                <td>COL</td>
            </tr>
            <tr>
                <td>COL</td>
                <td>COL</td>
                <td>COL</td>
            </tr>
            <tr>
                <td>COL</td>
                <td>COL</td>
                <td>COL</td>
            </tr>
        </tbody>
    </table>

    <script>
        $(document).ready(function(){
            $("#nonFixedSample").colResizable({liveDrag:true});
            $("#test").colResizable({liveDrag:true});
        });
    </script>
</body>
</html>
