namespace :composer do
  desc 'Install dependencies'
  task :install do
    on roles(:app) do
      within release_path do
        execute 'docker-compose' , :run, '--no-deps', '--rm', 'todolist-server', :composer, :install, '--no-dev', '--quiet'
      end
    end
  end
end
