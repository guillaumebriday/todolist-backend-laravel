namespace :user do
  desc 'Giving www-data the proper permission to write'
  task :storage do
    on roles(:app) do
      within release_path do
        execute :chown, '-R', 'www-data:www-data', 'storage/framework', 'storage/logs'
      end
    end
  end
end
