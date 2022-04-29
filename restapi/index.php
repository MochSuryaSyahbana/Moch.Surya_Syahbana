<!Doctype html>
<html>

<head>
    <title>
        Rest API
    </title>
</head>

<style>
th,td{
    height: 50px;
    width: 150px;
}
table,th,td{
    border: 1px solid black;
    border-collapse: collapse;
    text-align : center;
}
</style>
<body>
    <h1>
        Input Data Products
    </h1>

    <?php
    $id = $name = $price = $quantity = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $id = input_data($_POST["id"]);
        $name = input_data($_POST["name"]);
        $price = input_data($_POST["price"]);
        $quantity = input_data($_POST["quantity"]);
    }

    function input_data($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function post_data($url, $id, $name, $price, $quantity){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n\t\"id\":\"$id\",\n\t\"name\":\"$name\",\n\t\"price\":\"$price\",\n\t\"quantity\":\"$quantity\"}",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    
    function get_data($url){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <pre>ID     : <input type="text" required="requaired" name="id"
                value=""><br></pre>
        <pre>Name    : <input type="text" required="requaired" name="name"
                value=""><br></pre>
        <pre>Price     : <input type="text" name="price"
                value=""><br></pre>
        <pre>Quantity     : <input type="text" required="requaired" name="quantity"
                value=""><br></pre>

        <input type="submit" name="button"
                value="Submit"><br>
    </form>
    <?php
        if(isset($_POST['button'])){
            $data = post_data("http://192.168.50.3:5010/products",$id, $name, $price, $quantity);
            echo "<br>Data Berhasil Dikirim<br>";
        }
    ?>

    </h1>
        DATA PRODUCTS
    </h1>
    <?php
        $dataproducts = get_data("http://192.168.50.3:5010/get_data");
        $obj = json_decode($dataproducts, true);
        echo '<table>
        <tr>
            <th>ID</th><th>Name</th><th>Price</th><th>Quantity</th><th>Date Create</th><th>Date Update</th>
        </tr>

        </table>';
    foreach($obj as $item){
        $id = $item["id"];
        $name = $item["name"];
        $price = $item["price"];
        $quantity = $item["quantity"];
        $createdAt = $item["createdAt"];
        $updatedAt = $item["updatedAt"];
        echo '<table>
            <tr>
                <td>'.$id.'</td><td>'.$name.'</td><td>Rp.'.$price.'</td><td>'.$quantity.'</td><td>'.$createdAt.'</td><td>'.$updatedAt.'</td>
            </tr>
        </table>';
    }
    ?>  
</body>
</html>