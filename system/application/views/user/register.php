<h1>Inscription</h1>
<?php echo validation_errors(); ?>
<?php
if(isset($connexion_error)) {
	echo "<p>".$connexion_error."</p>";
}
?>
<?php echo form_open('user/register');
echo '<ul>';

$options = array(
                  'pro'  => 'Professionnel',
                  'part'    => 'Particulier'
                );

echo '<li>';
echo form_label('Statut', 'status');
echo form_dropdown('status', $options, 'pro', 'id = "status"');
echo '</li>';

$data_email = array(
              'name'        => 'email',
              'id'          => 'email',
              'value'       => $this->input->post('email'),
              'size' => '75',
              'maxlength' => '50',
            );
echo '<li>';
echo form_label('Adresse Mail', 'email');
echo form_input($data_email);
echo '</li>';

$data_password = array(
              'name'        => 'password',
              'id'          => 'password',
              'value'       => $this->input->post('password'),
              'size' => '75',
              'maxlength' => '200',
              'type' => 'password'
            );
echo '<li>';
echo form_label('Mot de passe', 'password');
echo form_input($data_password);
echo '</li>';

$data_password2 = array(
              'name'        => 'password2',
              'id'          => 'password2',
              'value'       => $this->input->post('password2'),
              'size' => '75',
              'maxlength' => '200',
              'type' => 'password'
            );
echo '<li>';
echo form_label('Retapper le de passe', 'password2');
echo form_input($data_password2);
echo '</li>';

echo form_submit('Inscription', 'Inscription');
//<div><input type="submit" value="Submit" /></div>
echo '</ul>';

echo form_close();
?>
