<?php

require_once('../model/operacao.php');

function isTheseParametersAvailable($params){
    $avalilable = true;
    $missingparams = "";

    foreach($params as $param)
    if(!isset($_POST[$params]) || strlen($_POST[$params])<=0){
        $avalilable = false;
        $missingparams = $missingparams. ", " .$param;
    }


if(!$avalilable){
    $response = array();
    $response['error'] = true;
    $response['message'] = 'Parameters ' .substr($missingparams, 1, strlen($missingparams)).' missing';

    echo json_encode($response);

    die();
}
}

$response = array();

if(isset($_GET['apicall'])){
    switch($_GET['apicall']){
        case 'createDesenho':
            isTheseParametersAvailable(array('campo_2','campo_3'));
            
            $db = new Operacao();

            $result = $db->createDesenho(
                $_POST['campo_2'],
                $_POST['campo_3'],
            );
            if($resukt){
                $response['error'] = false;
                $response['message'] = 'Dados inseridos com sucesso.';
                $response['dadoscreate'] = $db->getDesenho();
         }else{
             $response['error'] = true;
             $response['message'] = 'Dados não foram inseridos.';
         }

         break;
         case 'getDesenho':
            $db = new Operacao();
            $response['error'] = false;
            $response['message'] = 'Dados listados com sucesso.';
            $response['dadoslista'] = $db->getDesenho();

            break;
            case 'updateDesenho':
                isTheseParametersAvailable(array('campo_1','campo_2','campo_3'));

                $db = new Operacao();
                $result = $db->updateDesenho(
                    $_POST['campo_1'],
                    $_POST['campo_2'],
                    $_POST['campo_3'],
                );
                if($result){
                    $response['error'] = false;
                    $response['message']="Dados alterados com sucesso.";
                    $response['dadosalterar'] =  $db ->getDesenho();
                }else{
                    $response['error'] = true;
                    $response['message'] = "Dados não alterados.";
                }
                break;
                case 'deleteDesenho':
                    if(isset($_GET['uid'])){
                        $db = new Operacao();
                        if($db->deleteDesenho($_GET['uid'])){
                            $response['error'] = false;
                            $response['message'] = "Dados excluidos com sucesso";
                            $response['deleteDesenho'] = $db->getDesenho();
                        }else{
                            $response['error'] = true;
                            $response['message'] ="Algo deu errado.";
                        }
            }else{
                $response['error'] = true;
                $response['message'] = "Dados não apagados.";
            }
            break;
    }
}else{
    $response['error'] = true;
    $response['message'] = "Chamada de Api com defeito";
}

echo json_encode($response);