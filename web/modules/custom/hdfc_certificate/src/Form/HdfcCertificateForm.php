<?php

namespace Drupal\hdfc_certificate\Form;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\Element\EntityAutocomplete;

/**
 * Class MyAutocompleteForm
 * @package Drupal\mymodule\Form
 */
class HdfcCertificateForm extends FormBase
{

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'hdfc_certificate_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $form['article'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Autocomplete Articles'),
      '#autocomplete_route_name' => 'hdfc_certificate.autocomplete',
    ];
    $form['actions'] = ['#type' => 'actions'];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
    ];
    $form['field_upload_certificate'] = [
      '#type' => 'managed_file',
      '#title' => 'Certificate',
      '#required' => TRUE,
      '#upload_location' => 'private://files/certificates',
      '#upload_validators' => [
        'file_validate_extensions' => ['pem cer crt'],
      ],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $article_id = EntityAutocomplete::extractEntityIdFromAutocompleteInput($form_state->getValue('article'));
    \Drupal::messenger()->addMessage('Article ID is ' . $article_id);
    $field = $form_state->getValues();
    $path = $field['field_upload_certificate'];
    $cert_content = file_get_contents( $path );
    $res = openssl_x509_read( $cert_content );
    kint($res);
    die;
  }



}
