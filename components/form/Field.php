<?php

namespace app\components\form;

class Field {
  const TEXT = 'text';
  const PASSWORD = 'password';

  private string $label = '';
  private string $attr = '';
  private string $value = '';
  private string $error = '';

  public function __construct(string $label, string $name) {
    $this->label = $label;
    $this->attr = $name;
  }

  public function setData(string $value, string $error) {
    $this->value = $value;
    $this->error = $error;
  }

  public function render(string $type = self::TEXT) {
    return sprintf(
      '<div class="mb-3">
        <label class="form-label">%s</label>
        %s
        <div class="invalid-feedback">%s</div>
      </div>',
      $this->label,
      $this->renderInputOnly($type),
      $this->error
    );
  }

  public function renderInputOnly(string $type = self::TEXT) {
    return sprintf(
      '<input 
      type="%s" 
      name="%s" 
      value="%s" 
      autocomplete="off"
      class="form-control %s">',
      $type,
      $this->attr,
      $this->value,
      empty($this->error) ? '' : 'is-invalid'
    );
  }
}
