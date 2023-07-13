<?php

namespace App\Helpers;

use App\Models\Nodes;
use DiDom\Document;
use DiDom\Node;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Psr7\Utils;
use Symfony\Component\DomCrawler\Crawler;


class ParceHelper
{

    static public function findCssOrXpath(Document $document, string $selector)
    {
        if (substr($selector, 0, 1) == '/') {
            return $document->xpath($selector);
        } else {
            return $document->find($selector);
        }
    }


    static public function getDocument2($url, $id_node)
    {

        $document = null;
        // Создание экземпляра клиента Guzzle
        $client = new Client();
        $cookieJar = new CookieJar();

        // Аутентификационные данные
        $username = 'troser1005@gmail.com';
        $password = 'Gele@n2023';

        // Опции для отправки запроса POST на страницу входа
        $options = [
            'form_params' => [
                'login[username]' => $username,
                'login[password]' => $password,
            ],
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.93 Safari/537.36',
            ],
            'cookies' => $cookieJar, // Передайте CookieJar в опции запроса
        ];

        // Отправка запроса POST для аутентификации
        $response = $client->request('POST', 'https://shop.tiptopol.eu/customer/account/login/', $options);

        // Получение содержимого ответа
        $html = $response->getBody()->getContents();

        // Вывод содержимого полученной страницы
       // echo $html;
        // Выводим содержимое полученной страницы
        if ($response->getStatusCode() === 200) {
            $cookies = $client->getConfig('cookies');

            // После успешной авторизации, сохраните cookies
            $pageResponse = $client->get($url, [
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.93 Safari/537.36',
                ],
                'cookies' => $cookies
            ]);

            // Получение содержимого потока в виде строки
            $html = $pageResponse->getBody();

            // Запись HTML-контента в файл
            $file = 'd:/file1.html'; // Укажите путь и имя файла, куда нужно записать HTML
            file_put_contents($file, $html);
        }

        return $document;
    }

    static public function getDocument($url, $id_node)
    {

        $document = null;
        $url = CorrectUrl::Handle($url, $id_node); //check and correct url before loading

        $node = Nodes::find($id_node);
        if ($node->login) {
            // Создание экземпляра клиента GuzzleHttp с включенными cookies
            $client = new Client(['cookies' => new CookieJar()]);

            // Отправка GET-запроса для получения страницы с CSRF-токеном
            $initialResponse = $client->get('https://shop.tiptopol.eu/customer/account/login', [
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.93 Safari/537.36',
                ],
            ]);


            // Создание объекта Document из полученного HTML-контента
            $initialDocument = new Document($initialResponse->getBody()->getContents());

            // Извлечение CSRF-токена из формы авторизации
            $csrfToken = $initialDocument->find('input[name="form_key"]')[0]->getAttribute('value');

            // Отправка POST-запроса для авторизации с добавленным CSRF-токеном
            $response = $client->post('https://shop.tiptopol.eu/customer/account/login', [
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.93 Safari/537.36',
                ],
                'form_params' => [
                    'form_key' => $csrfToken,
                    'login[username]' => 'troser1005@gmail.com',
                    'login[password]' => 'Gele@n2023'
                ]
            ]);

            // Проверка успешности авторизации
            if ($response->getStatusCode() === 200) {
                // После успешной авторизации, сохраните cookies
                $cookies = $client->getConfig('cookies');

                // После успешной авторизации, сохраните cookies
                $pageResponse = $client->get($url, [
                    'headers' => [
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.93 Safari/537.36',
                    ],
                    'cookies' => $cookies
                ]);

                // Получение содержимого потока в виде строки
                $html = $pageResponse->getBody();

                // Запись HTML-контента в файл
                $file = 'd:/file1.html'; // Укажите путь и имя файла, куда нужно записать HTML
                file_put_contents($file, $html);

                // Создание объекта Document из полученного HTML-контента
                $document = new Document($pageResponse->getBody());
                //   $document = new Document('https://sklep.tiptopol.pl/ciezarki-klejone-olowiane.html', true);

                // dd($html);

                //echo "Заголовок страницы: " . $pageTitle;
            } else {
                // Авторизация не удалась
                echo "Ошибка авторизации";
            }
        } else {
            $document = new Document($url, true);
        }
        return $document;
    }
}
