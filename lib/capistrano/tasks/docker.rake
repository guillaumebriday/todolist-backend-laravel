namespace :docker do
  desc 'Build images'
  task :build do
    on roles(:app) do
      set :previous_release_path, previous_release
      within release_path do
        execute :docker, :build, '-t', fetch(:application), "#{release_path}/.cloud/docker"
      end
    end
  end

  desc 'Stopping old containers'
  task :stop do
    on roles(:app) do
      if fetch(:previous_release_path, false)
        within fetch(:previous_release_path) do
          containers = capture :'docker-compose', 'ps', '-q'
          unless containers.empty?
            info "Purging containers of previous release at #{fetch(:previous_release_path)}"
            execute :'docker-compose', 'down', '--remove-orphans'
          end
        end
      end
    end
  end

  desc 'Run app containers'
  task :up do
    on roles(:app) do
      within release_path do
        execute "docker-compose", :up, "-d"
      end
    end
  end

  def previous_release
    path = "#{fetch(:deploy_to)}/current"

    if test("[ -L #{path} ]")
      return capture("readlink -f #{path}")
    end

    return nil
  end
end
