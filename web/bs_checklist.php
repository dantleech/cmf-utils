<?php

// script to 
//
const BS_URL = 'http://symfony.com/doc/master/cmf/contributing/bundles.html';

function get_link($el, $prefix = '')
{
    $link = BS_URL.'#'.$el->parentNode->getAttribute('id');
    return sprintf('- [ ] %s[%s](%s)',
        $prefix,
        $el->childNodes->item(0)->nodeValue,
        $link
    );
}

$dom = new DOMDocument();
$dom->loadHTML(file_get_contents(BS_URL));
$xpath = new \DOMXpath($dom);
$h2s = $xpath->query('//div[@class="box_article doc_page"]//h2');

$out = array();

foreach ($h2s as $h2) {
    $out[] = get_link($h2);
    $h3s = $xpath->query('.//h3', $h2->parentNode);
    foreach ($h3s as $h3) {
        $out[] = get_link($h3, '> ');
    }
}

?>

<html>
<head>
<title>CMF Bundle Standards Issue Template Generator</title>
</head>
<body>
<h1>CMF Bundle Standards Issue Template Generator</h1>
<p>This script automatically parses the <a href="<?php echo BS_URL ?>">bundle standards document</a> and generates a checklist in Markdown format.</p>
<pre style="background-color: black; color: white;">
<?php echo implode("\n", $out) ?>
</pre>
</body>
</html>
