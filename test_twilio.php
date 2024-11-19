<?php


require __DIR__.'../vendor/autoload.php';
 // Substitua pelo caminho correto do autoload do Composer

use Twilio\Rest\Client;

// Configurações do Twilio
$sid = 'AC438fe6eaa9283a83bd9d5b5abb8f84e8'; // Substitua pelo seu Account SID
$token = 'b27ab33ac9d01bb711481284a66716ae'; // Substitua pelo seu Auth Token

$twilio = new Client($sid, $token);

try {
    $validationRequest = $twilio->validationRequests->create(
        "+244923766405", // Substitua pelo número de telefone
        ["friendlyName" => "Meu Número de Teste"]
    );

    echo "Código enviado para o número: " . $validationRequest->phoneNumber . PHP_EOL;
    echo "Código gerado: " . $validationRequest->validationCode . PHP_EOL;

} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . PHP_EOL;
}
