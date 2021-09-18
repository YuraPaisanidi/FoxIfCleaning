<?php

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'phpmailer/src/Exception.php';
	require 'phpmailer/src/PHPMailer.php';
	require 'phpmailer/src/SMTP.php';

	$mail = new PHPMailer(true);
	$mail->CharSet = 'UTF-8';
	$mail->setLanguage('ru', 'phpmailer/language/');
	$mail->IsHTML(true);

	//От каго письмо
	$mail->setFrom('yura.paisanidi@gmail.com', 'Стартовый макет');
	//Кому отправить
	$mail->addAddress('yura.paisanidi@gmail.com');
	//Тема письма
	$mail->Subject = ('Привет это тест отправки формы');

	//Рука
	$hand = 'Правая';
	if($_POST['hand'] == 'left') {
		$hand = 'Левая';
	}

	//Тело письма
	$body = '<h1>Заголовок письма</h1>';

	if(trim(!empty($_POST['name']))) {
		$body.='<p><strong>Имя: </strong>' . $_POST['name']. '</p>';
	}
	if(trim(!empty($_POST['age']))) {
		$body.='<p><strong>Возраст: </strong>' . $_POST['age']. '</p>';
	}
	if(trim(!empty($_POST['exp']))) {
		$body.='<p><strong>Опыт в сфере уборки: </strong>' . $_POST['exp']. '</p>';
	}
	if(trim(!empty($_POST['height']))) {
		$body.='<p><strong>Рост: </strong>' . $_POST['height']. '</p>';
	}
	if(trim(!empty($_POST['weight']))) {
		$body.='<p><strong>Вес: </strong>' . $_POST['weight']. '</p>';
	}
	if(trim(!empty($_POST['status']))) {
		$body.='<p><strong>Семейное положение: </strong>' . $_POST['status']. '</p>';
	}
	if(trim(!empty($_POST['child']))) {
		$body.='<p><strong>Дети: </strong>' . $_POST['child']. '</p>';
	}
	if(trim(!empty($_POST['city']))) {
		$body.='<p><strong>Место проживания: </strong>' . $_POST['city']. '</p>';
	}
	if(trim(!empty($_POST['phone']))) {
		$body.='<p><strong>Номер телефона: </strong>' . $_POST['phone']. '</p>';
	}

	//Прикрепить файл
	if (!empty($_FILES['image']['tmp_name'])) {
		//путь загрузки файла
		$filePath = __DIR__ . '/files/' . $_FILES['image']['name'];

		//загрузим файл
		if (copy($_FILES['image']['tmp_name'], $filePath)) {
			$fileAttach = $filePath;
			$body.='<p><strong>Фото в приложении</strong></p>';
			$mail->addAttachment($fileAttach);
		}
	}

	$mail->Body = $body;

	//Отправляем
	if (!$mail->send()) {
		$message = 'Ошибка';
	} else {
		$massage = 'Данные отправлены!';
	}

	$response = ['message' => $massage];

	header('Content-type: application/json');
	echo json_encode($response);


?>