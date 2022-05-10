<?php

namespace Drupal\custom_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\file\Entity\File;
use Drupal\file\FileInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class CustomForm.
 */
class CustomForm extends FormBase {


  /**
   *{@inheritdoc}
   */
  public function getFormId()
  {
    return 'custom_form';
  }

  /**
   *{@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#description' => $this->t('Enter your fullname'),
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '0',
    ];
    $form['phone'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Phone'),
      '#description' => $this->t('Enter your phone number'),
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '0',
    ];
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#description' => $this->t('Enter your email'),
      '#weight' => '0',
    ];
    $form['profile_image'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Profile Image'),
      '#upload_location' => 'public://certfiles',
      '#upload_validators' => [
        'file_validate_extensions' => ['jpg jpeg png'],
      ],
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    parent::validateForm($form, $form_state);
  }

  /**
   * @return array
   */
  private function getAllowedFileExtensions(){
    return array('jpg jpeg gif png txt doc docx zip xls xlsx pdf ppt pps odt ods odp');
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $field = $form_state->getValues();
    $name = $field['name'];
    $number = $field['phone'];
    $email = $field['email'];
    $files = $form_state->getValue('profile_image',0);
    if(!empty($files)) {
      $file = File::load($files[0]);
      $file->setPermanent();
      $file->save();
    }

    // $file =File::load($file->id());
    // $path = $file->url();
    // print_r($path);
    // die("ddddddddd");

    $insert = array('uid'=>1,'name' => $name, 'phone' => $number, 'email' => $email, 'profile_image' => $file->id());
    db_insert('my_custom_frm')
      ->fields($insert)
      ->execute();
      
    if ($insert == TRUE) {
      drupal_set_message("your application subimitted successfully");
    } else {
      drupal_set_message("your application not subimitted ");
    }
  }
}
