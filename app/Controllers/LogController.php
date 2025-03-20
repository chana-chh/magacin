<?php

namespace App\Controllers;

use App\Models\Log;
use App\Classes\Controller;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LogController extends Controller
{
    public function getLogLista(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $path = $request->getUri()->getPath();
        $query = $request->getQueryParams();
        $page = $query['page'] ?? 1;
        $modelLog = new Log();
        $sql = "SELECT * FROM logovi ORDER BY vreme DESC;";
        $logovi = $modelLog->paginate($path, $page, $sql, [], 2, 3);
        return $this->render($response, 'logovi.twig', compact('logovi')); //
    }
}
