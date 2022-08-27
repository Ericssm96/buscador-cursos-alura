<?php

namespace Alura\BuscadorDeCursos;

use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class Buscador
{
    private ClientInterface $cliente;
    private Crawler $crawler;

    public function __construct(ClientInterface $cliente, Crawler $crawler)
	{
		$this->cliente = $cliente;
		$this->crawler = $crawler;
	}

	public function buscar($url): array
	{
		$resposta = $this->cliente->request('GET', $url);

		$html = $resposta->getBody();
		$this->crawler->addHtmlContent($html);

		$elementosCursos = $this->crawler->filter('span.card-curso__nome');

		$cursos = [];

		foreach ($elementosCursos as $elemento) {
			$cursos[] = $elemento->textContent;
		}

		return $cursos;
	}
}