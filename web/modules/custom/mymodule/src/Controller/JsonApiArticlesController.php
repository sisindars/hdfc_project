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
//    $input = Xss::filter($input);
//    $query = \Drupal::entityQuery('user');
//    $result = $query->execute();
    $ids = \Drupal::entityQuery('user')
      ->condition('status', 1)
      ->condition('roles', 'administrator')
      ->execute();
     $users = User::loadMultiple($ids);
      foreach($users as $user) {
        $username = $user->get('name')->getString();
        $mail = $user->get('mail')->getString();
        if ($mail[0] = $input) {
          $userlist[] = $mail;
        }
      }
//    kint($userlist);
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

//    kint($results);
//    die('testing');
    return new JsonResponse($userlist);
  }

}
