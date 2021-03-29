<?php

namespace app\components\form;

use app\core\Component;

class Field extends Component {
  const TEXT = 'text';
  const PASSWORD = 'password';

  public function __construct(string $label, string $name, string $type = self::TEXT) {
    parent::__construct(
      ['label' => $label,'name' => $name, 'type' => $type]);
  }

  public function setData(string $value, string $error) {
    $this->state['value'] = $value;
    $this->state['error'] = $error;
  }

  public function render() {
    echo sprintf(
      '<div class="mb-3">
        <label class="form-label">%s</label>
        %s
        <div class="invalid-feedback">%s</div>
      </div>',
      $this->state['label'],
      $this->generateInputOnly(),
      $this->state['error']
    );
  }

  public function generateInputOnly() {
    return sprintf(
      '<input 
      type="%s" 
      name="%s" 
      value="%s" 
      autocomplete="off"
      class="form-control %s">',
      $this->state['type'],
      $this->state['name'],
      $this->state['value'],
      !isset($this->state['error']) || empty($this->state['error']) ? '' : 'is-invalid'
    );
  }
}
