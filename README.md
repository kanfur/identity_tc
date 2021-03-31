# identity_tc
php.ini içinden extension:soap ya da php_soap bulup aktif edin. webserverı tekrar başlatın.

Adı, Soyadı ve Doğum Yılı bilinen bir kişinin T.C. Kimlik Numarası'nın doğruluğunu kontrol eder.

Postman collection json dosyası root dizinindedir.

Php - cURL örneği;

    <?php

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'http://localhost:1011/api/authenticate/tc',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => array('identity_no' => '24710697399','name' => 'hüseyin','surname' => 'öztürk','birthday' => '1993-04-13','province' => 'İstanbul','district' => 'Kağıthane','wallet serial' => '123','wallet no' => '123123','identity_new' => 'true'),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;

