<?php

namespace App\Http\Controllers;

use NFePHP\DA\NFe\Danfe;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function testGetDanfe()
    {
        try {
            $xml = storage_path('35231018046109000125550010000000011000000024-NFe.xml');
            // $logo = 'data://text/plain;base64,'. base64_encode(file_get_contents(realpath(__DIR__ . '/../images/tulipas.png')));
            $xmlString = file_get_contents($xml);

            $danfe = new Danfe($xmlString, 'P', 'A4', '', 'I', '');

            $danfe->exibirTextoFatura = true;
            $danfe->exibirPIS = false;
            $danfe->exibirIcmsInterestadual = false;
            $danfe->exibirValorTributos = false;
            $danfe->descProdInfoComplemento = false;

            // Caso queira mudar a configuracao padrao de impressao
            // $this->printParameters(
            //     $orientacao = 'P',
            //     $papel = 'A4',
            //     $margSup = 2,
            //     $margEsq = 2
            // );

            $danfe->creditsIntegratorFooter('SIGA Sistemas');

            // Caso queira sempre ocultar a unidade tributável
            // $this->setOcultarUnidadeTributavel(true);

            $id = $danfe->montaDANFE();
            $pdf = $danfe->render(); //$logo

            // $id = \App\library\Token::genIntSeq();
            // $arquivoPath = app_path("data/tmp/{$id}.tmp");
            $arquivoPath = storage_path($id . '.pdf');
            file_put_contents($arquivoPath, $pdf);
            $headers = [
                'Content-Type' => 'application/pdf',
            ];

            return response()->download($arquivoPath, $id . '.pdf', $headers);

            
        } catch (\Exception $e) {
            echo "Ocorreu um erro durante o processamento :" . $e->getMessage();
        }
    }
}
