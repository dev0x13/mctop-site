<?php
	class Mctop
	{
		public function getMCTopAddress()
		{
			echo json_encode(array('address'=>gethostbyname('dev.mctop.im')));
		}
	}