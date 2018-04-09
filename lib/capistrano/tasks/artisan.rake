namespace :artisan do
  desc 'Running migrations'
  task :migrate do
    on roles(:app) do
      within release_path do
        execute 'docker-compose' , :run, '--rm', 'todolist-server', :php, :artisan, :migrate, '--force'
      end
    end
  end

  desc 'Running seed'
  task :seed do
    on roles(:app) do
      within release_path do
        execute 'docker-compose' , :run, '--rm', 'todolist-server', :php, :artisan, 'db:seed', '--force'
      end
    end
  end
end
