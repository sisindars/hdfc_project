<?php

namespace Drupal\mymodule\Controller;

use Drupal;
use Drupal\Component\Serialization\Json;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\RedirectCommand;
use Drupal\Core\Entity\Element\EntityAutocomplete;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Component\Utility\Xss;
use Drupal\user\Entity\User;




/**
 * Class JsonApiArticlesController
 * @package Drupal\mymodule\Controller
 */
class JsonApiArticlesController
{

  /**
   * @return JsonResponse
   */
  public function handleAutocomplete(Request $request)
  {
    $results = [];
    $input = $request->query->get('q');
//    die('test'.$input);
    if (!$input) {
      return new JsonResponse($results);

    }
    $input = Xss::filter($input);
//    $query = \Drupal::entityQuery('user');
//    $result = $query->execute();
    $ids = \Drupal::entityQuery('user')

      ->execute();
    $user = User::loadMultiple($ids);
    $users = reset($user);
//    kint($users->mail);
//    die('sisi');

//    $query = \Drupal::entityQuery('user')
//      ->condition('role', 'partner')
//      ->condition('title', $input, 'CONTAINS')
//      ->groupBy('nid')
//      ->sort('created', 'DESC')
//      ->range(0, 10);
//    $result = $query->execute();
//    $nodes = $results ? \Drupal\node\Entity\Node::loadMultiple($results) : [];
//    $uids = array_keys($result['user']);
//    kint($uids);
//    die('drupal');
// THIS IS YOUR ARRAY OF UIDS.
//      $users = user_load_multiple($uids);
//    foreach ($users as $user) {
//      $results[] = [
////        'value' => EntityAutocomplete::getEntityLabels([$node]),
////        'label' => $node->getTitle().' ('.$node->id().')',
//        'email' => $user->mail,
//
//      ];
//    }
//    kint($results);
//    die('testing');
    return new JsonResponse($results);
  }

}
