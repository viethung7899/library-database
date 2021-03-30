<?php

namespace app\core;

class View {
  private string $layout;
  private string $view;
  private string $title;
  private array $params;

  public function __construct(string $view = 'index', string $layout = 'withNavigation') {
    $this->layout = $layout;
    $this->view = $view;
    $this->title = 'Document';
    $this->params = [];
  }

  public function setLayout(string $layout) {
    $this->layout = $layout;
  }

  public function setView(string $view) {
    $this->view = $view;
  }

  public function setTitle(string $title) {
    $this->title = $title;
  }

  public function loadParameters(array $params) {
    $this->params = $params;
  }

  public function render() {
    // Set up the variable before making view content
    foreach ($this->params as $name => $value) {
      $$name = $value;
    }
    
    // Start making view content object
    ob_start();
    include_once Application::getRootDir()."/views/".$this->view.".php";
    $content = ob_get_clean();
    
    // Render content with the layout
    $title = $this->title ?? 'Home';
    include_once Application::getRootDir()."/views/_layout/".$this->layout.".php";
  }
}