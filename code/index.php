<?php
session_start();												//���������� ���������
if (isset($_SESSION["session_lusername"])) {					//�� ���� �������� ������� �������
	header("Location: learner/lhome.php");						//������������� �� lhome.php
}
else if (isset($_SESSION["session_pusername"])) {				//�� ���� �������� � ���������
	header("Location: professor/phome.php");					//������������� �� phome.php
}
else {															//�� ��� ���� �������� �������
	header("Location: login_register_form.php" );				//������������� �� login_register_form.php	
}
?>