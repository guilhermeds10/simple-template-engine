<?php

    class Template {

        private $variables = [];
        private $template;

        public function __construct($template, $variables = []){
            $this->template = file_get_contents($template);
            $this->variables = $variables;

            $this->render();
        }

        private function replaceTags(){
            $this->template = str_replace('{%', '<?php', $this->template);
            $this->template = str_replace('%}', '?>', $this->template);
            $this->template = str_replace('{{', '<?php echo ', $this->template);
            $this->template = str_replace('}}', '?>', $this->template);
        }

        public function render(){
            $this->replaceTags();
            foreach ($this->variables as $variable => $value){
                ${$variable} = $value;
            }
            eval(sprintf('?>%s<?', $this->template));
        }
    }

    $testers = ['tester1', 'tester2'];

    $variables = [
        'title' => 'My first simple template engine.',
        'testers' => $testers,
        'date_time' => date('Y-m-d H:i:s')
    ];

    $path_to_file = 'view.html';

    $template = new Template($path_to_file, $variables);
