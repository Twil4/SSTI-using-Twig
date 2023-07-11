<?php 

require 'vendor/autoload.php';
require 'conn.php';

$loader = new \Twig\Loader\FilesystemLoader('views');
//$twig = new \Twig\Environment($loader);
$twig = new \Twig\Environment($loader, [
    'autoescape' => false
]);

$lexer = new \Twig\Lexer($twig, array(
	'tag_block'    => array('{', '}'),
	'tag_variable' => array('{{', '}}')
));

$twig->setLexer($lexer);

$sql = "SELECT * FROM meo";
$result = mysqli_query($connect, $sql);
$meoArray = array();
if(mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)){
		$meo = array(
			'ID' => $row['ID'],
			'name' => $row['name'],
			'content' => $row['content'],
			'link' => $row['link']
		);
		$meoArray[] = $meo;
	}
}

if(empty($_GET)){
	echo $twig->render('meo.html',[ 
		'meoArray' => $meoArray
	]);
}

if(isset($_GET['ID'])){
	$template = $twig->load('hello.html');
	echo $template->render(['data' => $_GET['ID']]);
}