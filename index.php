<?php

/*GET /sucupira/public/consultas/coleta/docente/listaDocente.jsf HTTP/1.1
Host: sucupira.capes.gov.br
Connection: keep-alive
Cache-Control: max-age=0
Upgrade-Insecure-Requests: 1
User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*\/*;q=0.8
Referer: https://www.google.com.br/
Accept-Encoding: gzip, deflate, br
Accept-Language: pt-BR,pt;q=0.8,en-US;q=0.6,en;q=0.4*/

//$ckfile = tempnam ("/tmp", "CURLCOOKIE");
$ckfile = dirname(__FILE__) . '/cookie.txt';

$ch = curl_init('https://sucupira.capes.gov.br/sucupira/public/consultas/coleta/docente/listaDocente.jsf');
curl_setopt($ch, CURLOPT_COOKIEJAR, $ckfile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $ckfile);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$headers = [
    'Host: sucupira.capes.gov.br',
    'Connection: keep-alive',
    'Cache-Control: max-age=0',
    'Upgrade-Insecure-Requests: 1',
    'User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36',
    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*\/*;q=0.8',
    'Referer: https://google.com.br',
    'Accept-Encoding: gzip, deflate, br',
    'Accept-Language: pt-BR,pt;q=0.8,en-US;q=0.6,en;q=0.4',
];

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// get headers too with this line
curl_setopt($ch, CURLOPT_HEADER, 1);
$result = curl_exec($ch);

// get cookie
// multi-cookie variant contributed by @Combuster in comments
preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);
$cookies = array();
foreach($matches[1] as $item) {
    parse_str($item, $cookie);
    $cookies = array_merge($cookies, $cookie);
}

$cookie = array_pop($cookies);

$dom = new DOMDocument();
libxml_use_internal_errors(true);
$dom->loadHTML($result);
$data = $dom->getElementById("javax.faces.ViewState");
$viewState = str_replace(':', '%3A', $data->getAttribute('value'));

curl_close($ch);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://sucupira.capes.gov.br/sucupira/public/consultas/coleta/docente/listaDocente.jsf');
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36');
curl_setopt($ch, CURLOPT_POST, 1);

/*form=form&
form%3Aj_idt23%3Aano=2017&
form%3Aj_idt23%3Ainst%3AvalueId=4354&
form%3Aj_idt23%3Ainst%3Ainput=28001010%20UNIVERSIDADE%20FEDERAL%20DA%20BAHIA%20(UFBA)&
form%3Aj_idt23%3Aj_idt99=205000&
form%3Adocente=&
form%3Acategoria=3&
javax.faces.ViewState=1230730448448279533%3A4157464020732386004&
javax.faces.source=form%3Aconsultar&
javax.faces.partial.event=click&
javax.faces.partial.execute=form%3Aconsultar%20%40component&
javax.faces.partial.render=%40component&
javax.faces.behavior.event=action&
org.richfaces.ajax.component=form%3Aconsultar&
AJAX%3AEVENTS_COUNT=1&
javax.faces.partial.ajax=true*/

$fields = array(
    'form' => "form",
    'form:j_idt23:ano' => "2017",
    'form:j_idt23:inst:valueId' => "4354",
    'form:j_idt23:inst:input' => "28001010 UNIVERSIDADE FEDERAL DA BAHIA (UFBA)",
    'form:j_idt23:j_idt42' => "205000",
    //$select_id => "205000",
    'form:docente' => "",
    'form:categoria' => "3",
    'javax.faces.ViewState' => $viewState,
    'javax.faces.source' => "form:consultar",
    'javax.faces.partial.event' => "click",
    'javax.faces.partial.execute' => "form:consultar @component",
    'javax.faces.partial.render' => "@component",
    'javax.faces.behavior.event' => "action",
    'org.richfaces.ajax.component' => "form:consultar",
    'AJAX:EVENTS_COUNT' => "1",
    'javax.faces.partial.ajax' => "true",
);
$fields_string = http_build_query($fields);

//curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);  //Post Fields
curl_setopt($ch, CURLOPT_POSTFIELDS, "form=form&form%3Aj_idt23%3Aano=2017&form%3Aj_idt23%3Ainst%3AvalueId=&form%3Aj_idt23%3Ainst%3Ainput=ufba&form%3Aj_idt23%3Ainst%3Alistbox=4354&form%3Adocente=&form%3Acategoria=0&javax.faces.ViewState=" . $viewState . "&javax.faces.source=form%3Aj_idt23%3Ainst%3Alistbox&javax.faces.partial.event=change&javax.faces.partial.execute=form%3Aj_idt23%3Ainst%3Alistbox%20form%3Aj_idt23%3Ainst&javax.faces.partial.render=form%3Aj_idt23%3Ainst%3Ainst%20form%3Aj_idt23%3Ainst%3AvalueId%20form%3Aj_idt23%3Aprograma&javax.faces.behavior.event=valueChange&AJAX%3AEVENTS_COUNT=1&javax.faces.partial.ajax=true");  //Post Fields

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5000);
curl_setopt($ch, CURLOPT_VERBOSE, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 5000);

$headers = [
    'Host: sucupira.capes.gov.br',
    'Connection: keep-alive',
    'Faces-Request: partial/ajax',
    'Origin: https://sucupira.capes.gov.br',
    'User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36',
    'Content-type: application/x-www-form-urlencoded;charset=UTF-8',
    'Accept: */*',
    'Referer: https://sucupira.capes.gov.br/sucupira/public/consultas/coleta/docente/listaDocente.jsf',
    'Accept-Encoding: gzip, deflate, br',
    'Accept-Language: pt-BR,pt;q=0.8,en-US;q=0.6,en;q=0.4',
    //'Cookie: ' . $cookie,
];

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_COOKIEJAR, $ckfile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $ckfile);

$data = curl_exec($ch);

curl_setopt($ch, CURLOPT_POSTFIELDS, "form=form&form%3Aj_idt23%3Aano=2017&form%3Aj_idt23%3Ainst%3AvalueId=&form%3Aj_idt23%3Ainst%3Ainput=ufba&form%3Aj_idt23%3Ainst%3Alistbox=4354&form%3Adocente=&form%3Acategoria=0&javax.faces.ViewState=". $viewState . "&javax.faces.source=form%3Aj_idt23%3Ainst%3Alistbox&javax.faces.partial.event=change&javax.faces.partial.execute=form%3Aj_idt23%3Ainst%3Alistbox%20form%3Aj_idt23%3Ainst&javax.faces.partial.render=form%3Aj_idt23%3Ainst%3Ainst%20form%3Aj_idt23%3Ainst%3AvalueId%20form%3Aj_idt23%3Aprograma&javax.faces.behavior.event=valueChange&AJAX%3AEVENTS_COUNT=1&javax.faces.partial.ajax=true");  //Post Fields

$headers = [
    'Host: sucupira.capes.gov.br',
    'Connection: keep-alive',
    'Faces-Request: partial/ajax',
    'Origin: https://sucupira.capes.gov.br',
    'User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36',
    'Content-type: application/x-www-form-urlencoded;charset=UTF-8',
    'Accept: */*',
    'Referer: https://sucupira.capes.gov.br/sucupira/public/consultas/coleta/docente/listaDocente.jsf',
    'Accept-Encoding: gzip, deflate, br',
    'Accept-Language: pt-BR,pt;q=0.8,en-US;q=0.6,en;q=0.4',
    //'Cookie: ' . $cookie,
];

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$data = curl_exec($ch);

$fp = fopen('test.txt', 'w');
fwrite($fp, $data);
fclose($fp);

$dom = new DOMDocument();
$dom->loadHTML($data);
$select_id = $dom->getElementsByTagName('select')->item(1)->getAttribute('name');

curl_setopt($ch, CURLOPT_POSTFIELDS, "form=form&form%3Aj_idt23%3Aano=2017&form%3Aj_idt23%3Ainst%3AvalueId=4354&form%3Aj_idt23%3Ainst%3Ainput=28001010%20UNIVERSIDADE%20FEDERAL%20DA%20BAHIA%20(UFBA)&" . $select_id . "=205000&form%3Adocente=&form%3Acategoria=3&javax.faces.ViewState=" . $viewState . "&javax.faces.source=form%3Aconsultar&javax.faces.partial.event=click&javax.faces.partial.execute=form%3Aconsultar%20%40component&javax.faces.partial.render=%40component&javax.faces.behavior.event=action&org.richfaces.ajax.component=form%3Aconsultar&AJAX%3AEVENTS_COUNT=1&javax.faces.partial.ajax=true");  //Post Fields

$headers = [
    'Host: sucupira.capes.gov.br',
    'Connection: keep-alive',
    'Faces-Request: partial/ajax',
    'Origin: https://sucupira.capes.gov.br',
    'User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36',
    'Content-type: application/x-www-form-urlencoded;charset=UTF-8',
    'Accept: */*',
    'Referer: https://sucupira.capes.gov.br/sucupira/public/consultas/coleta/docente/listaDocente.jsf',
    'Accept-Encoding: gzip, deflate, br',
    'Accept-Language: pt-BR,pt;q=0.8,en-US;q=0.6,en;q=0.4',
];

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$data = curl_exec($ch);

$fp = fopen('test.txt', 'w');
fwrite($fp, $data);
fclose($fp);

$header = curl_getinfo($ch, CURLINFO_HEADER_OUT);
curl_close($ch);
