#Add function in bootstrap to get custom php code in theme file

#1.  need to create tpl in theme snippet file

#2.  make function in theme(child theme recommanded) Bootstrap.php


#Code 

  
               
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
        
       

