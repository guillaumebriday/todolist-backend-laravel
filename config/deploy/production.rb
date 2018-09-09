after 'deploy:updated', 'docker:build'
after 'deploy:updated', 'template:compose'
after 'deploy:updated', 'template:env'

after 'deploy:updated', 'composer:install'

after 'deploy:updated', 'user:storage'

after 'deploy:updated', 'docker:stop'

after 'deploy:updated', 'artisan:migrate'
after 'deploy:updated', 'artisan:seed'

after 'deploy:published', 'docker:up'
