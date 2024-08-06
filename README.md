#Add function in bootstrap to get custom php code in theme file

#1.  need to create tpl in theme snippet file

#2.  Define hook and function in theme(child theme recommanded) Bootstrap.php


#Code 

  ```
               
        /**
        * 
        * AJAX REQUESTS
        * 
        */
        // DISPATCHER FUNCTIONS
            $dispatcher = Dispatcher::getInstance();
        $listenTo = [
             \HOOK_SMARTY_OUTPUTFILTER, <!--here you can define hooks which you need for your function -->
            \HOOK_IO_HANDLE_REQUEST,
        ];
        foreach ($listenTo as $hook) {
            $dispatcher->listen('shop.hook.' . $hook, [$plugins, 'lsexec']);
        }
        
```


#3. make function in Plugins.php

#Code 

  ```
               
      // HOOK_SMARTY_OUTPUTFILTER 
     public function lsexec(array $args): void
     {   
         // Add below header text
         $this->addtimeinterval($args);
        
     }
     public function addtimeinterval()
     {
       //your code....

         // Get the Smarty instance
         $smarty = Shop::Smarty();
     
         // Check if the Smarty instance is valid
         if ($smarty !== null) {
             // Assign data to Smarty
           $freq_abo =  $smarty->assign('frequencies', $frequencies)
             ->fetch('snippets/ls/frequency_abo.tpl');
             pq('body .sub_abbo_weeks')->html($freq_abo); // it will appeant youjr custom html from tpl file to your theme file, like here i have added html in product details.tpl file. which will apear on product details page.
          
             // Optionally, log or handle $output if you need to process it further
             // For example, you can return it or print it if needed:
             // echo $output;
         } else {
             error_log('Smarty instance is null.');
         }
     }
        
```


#4. Add tpl file in snippets folder in my case i have created subfolder inside snippet name as LS. You can make any or just put file in snippet folder.

#your custom html will be define in tpl file.
