<?php

namespace app\components\form;

use app\core\Component;

class Field extends Component {
  const TEXT = 'text';
  const PASSWORD = 'password';
  private bool $label = false;

  public function __construct(string $label, string $name, string $type = self::TEXT) {
    parent::__construct(
      ['label' => $label,'name' => $name, 'type' => $type]);
  }

  public function setData(string $value, string $error) {
    $this->state['value'] = $value;
    $this->state['error'] = $error;
  }

  public function showLabel() {
    $this->label = true;
  }

  public function render() {
    if ($this->label) echo sprintf('<label class="form-label">%s</label>', $this->state['label']);
    echo $this->generateInputOnly();
    echo sprintf('<div class="invalid-feedback">%s</div>', $this->state['error']);
  }

  public function generateInputOnly() {
    return sprintf(
      '<input 
      type="%s" 
      name="%s"
      placeholder="%s"
      value="%s"
      autocomplete="off"
      class="form-control %s">',
      $this->state['type'],
      $this->state['name'],
      (!$this->label) ? $this->state['label'] : '',
      $this->state['value'],
      !isset($this->state['error']) || empty($this->state['error']) ? '' : 'is-invalid'
    );
  }
}
