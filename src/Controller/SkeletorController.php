<?php

namespace Drupal\skeletor_scaffold\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class SkeletorController.
 */
class SkeletorController extends ControllerBase {

  /**
   * React App.
   *
   * @return array
   *   React Application.
   */
  public function reactApp() {
    return [
      '#type'       => 'container',
      '#attributes' => ['id' => 'app'],
      'loading'     => ['#markup' => $this->t('Loading...')],
      '#attached'   => [
        'library' => ['skeletor_scaffold/app']
      ],
    ];
  }

}
