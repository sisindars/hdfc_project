<?php

namespace Drupal\custom_form\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;

/**
 * Class DisplayTableController.
 *
 * @package Drupal\custom_form\Controller
 */
class DisplayTableController extends ControllerBase {


  public function getContent() {
    // First we'll tell the user what's going on. This content can be found
    // in the twig template file: templates/description.html.twig.
    // @todo: Set up links to create nodes and point to devel module.
    $build = [
      'description' => [
        '#theme' => 'custom_form_description',
        '#description' => 'foo',
        '#attributes' => [],
      ],
    ];
    return $build;
  }

  /**
   * Display.
   *
   * @return string
   *   Return Hello string.
   */
  public function display() {
    /**return [
    '#type' => 'markup',
    '#markup' => $this->t('Implement method: display with parameter(s): $name'),
    ];*/

    //create table header
    $header_table = array(
//      'id'=>    t('SrNo'),
      'name' => t('Name'),
      'phone' => t('Phone'),
      'email'=>t('Email'),
      'profile_image'=>t('Profile Image'),
//      'age' => t('Age'),
//      'gender' => t('Gender'),
//      //'website' => t('Web site'),
//      'opt' => t('operations'),
//      'opt1' => t('operations'),
    );

//select records from table
    $query = \Drupal::database()->select('my_custom_frm', 'm');
    $query->fields('m', ['name','phone','email','profile_image']);
    $results = $query->execute()->fetchAll();
//    kint($results);
//    die;
    $rows=array();
    foreach($results as $data){
//      $delete = Url::fromUserInput('/mydata/form/delete/'.$data->id);
//      $edit   = Url::fromUserInput('/mydata/form/mydata?num='.$data->id);

      //print the data from table
      $rows[] = array(
//        'id' =>$data->id,
        'name' => $data->name,
        'phone' => $data->phone,
        'email' => $data->email,
        'profile_image'=>$data->profile_image
//        'age' => $data->age,
//        'gender' => $data->gender,
//        //'website' => $data->website,
//
//        \Drupal::l('Delete', $delete),
//        \Drupal::l('Edit', $edit),
      );

    }
    //display data in site
    $form['table'] = [
      '#type' => 'table',
      '#header' => $header_table,
      '#rows' => $rows,
      '#empty' => t('No users found'),
    ];
//        echo '<pre>';print_r($form['table']);exit;
    return $form;

  }

}
