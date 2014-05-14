<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Db_helper extends CI_Controller {


	public function list_fields($table_name='')
	{
		if($table_name=='')
		{
			exit('Please select table_name');
		}


		$fields = $this->db->list_fields($table_name);
		echo "// If form submitted !" .br();
		echo "if(\$this->input->post('submit')=='submit')" .br();
		echo "{".br();

		echo nbs(5). "// Form validation protection" .br();
		foreach ($fields as $field)
		{
			echo nbs(5). "\$this->form_validation->run('$field', '".ucfirst($field)."', 'required');" .br();
		}
		echo br();

		echo nbs(5). "if(\$this->form_validation->run()==TRUE)" .br();
		echo nbs(5). "{" .br();


		echo nbs(10). "// If all validation is passed" .br();
		echo nbs(10). "\$post = (object) \$this->input->post(NULL, TRUE);" . br();
		echo nbs(10). "\$params = array(" .br();
			foreach ($fields as $field)
			{
				echo nbs(15). "'$field'" . " => " . "\$post->$field," . br();
			}
			echo nbs(10).");" .br();		

			echo nbs(10). "if(\$this->db->insert('table_name',\$params)==TRUE)" .br();	
			echo nbs(10). "{".br();

			echo nbs(15). "// If successfull query" .br();
			echo nbs(15). "\$this->alert->set_success();".br();
			echo nbs(15). "redirect(base_url());".br();
			echo nbs(10). "}".br();
			
			echo nbs(10). "else".br();
			echo nbs(10). "{".br();
			echo nbs(15). "// If failed query" .br();
			echo nbs(15). "\$this->alert->set_failed();".br();
			echo nbs(15). "redirect(base_url());".br();
			echo nbs(10). "}".br();

			echo nbs(5)."}" .br();		
			echo "}";

			echo br(2);
			echo "\$data = '';" .br();
			echo "\$this->load->view('template', \$data);";

			// echo br(10);
		}


	public function form_generator($table_name='',$whit_value=false)
	{
		if($table_name=='')
		{
			exit('table name?');
		}

		$data =  '<form action="" method="POST" role="form">'."\r\r";

		$fields = $this->db->list_fields($table_name);
		foreach ($fields as $field) {
			$data .= '<div class="form-group">'. "\r";
			$data .= '<label for="'.$field.'">'.ucwords(str_replace('_', ' ', $field)).'</label>'. "\r";

			if($whit_value==false)
			{
				$data .= '<input name="'.$field.'" type="text" class="form-control">'. "\r";
			}
			else
			{
				$data .= '<input name="'.$field.'" value="<?php echo $'.$whit_value.'->'.$field.' ?>" type="text" class="form-control">'. "\r";
			}
			$data .= '</div>'. "\r\r";

		}
		$data .= '<button name="submit" value="xxx" type="submit" class="btn btn-primary btn-sm">Submit</button>';

		$data .= "\r\r</form>";

		echo "<textarea rows='50' cols='100'>$data</textarea>";
	}

}

	/* End of file db_helper.php */
/* Location: ./application/controllers/db_helper.php */
