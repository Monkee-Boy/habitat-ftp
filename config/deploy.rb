# config valid only for current version of Capistrano
lock '3.3.5'

# Load up the mBoy gem
Mboy.new() # Setting initial defaults.

set :application, 'habitat-ftp' # no spaces or special characters
set :project_name, 'Habitat FTP' # pretty name that can have spaces
set :repo_url, 'git@github.com:Monkee-Boy/habitat-ftp.git' # the git repo url
set :current_dir, 'public_html' # almost always public_html

# Default value for :linked_files is []
set :linked_files, fetch(:linked_files, []).push('.env') # Note that this file must exist on the server already, Capistrano will not create it.

# Default value for linked_dirs is []
set :linked_dirs, fetch(:linked_dirs, []).push('vendor')

namespace :deploy do
  STDOUT.sync

  desc 'Build'
  after :updated, :deploybuild do
    on roles(:web) do
      within release_path  do
        invoke 'build:composer'
        invoke 'build:artisan'
        invoke 'build:migratedb'
      end
    end
  end

  desc 'mBoy Deployment Initialized.'
  Mboy.deploy_starting_message

  desc 'Tag this release in git.'
  Mboy.tag_release

  desc 'mBoy Deployment Steps'
  Mboy.deploy_steps

  desc 'mBoy HipChat Notifications'
  Mboy.hipchat_notify

end

namespace :build do

  desc "Database migrations."
  task :migratedb do
    on roles(:web) do
      within release_path do
        execute :php, "artisan migrate --force" # run migrations
      end
    end
  end

  desc 'Setup Artisan.'
  task :artisan do
    on roles(:web) do
      within release_path do
        execute :chmod, "u+x artisan" # make artisan executable
      end
    end
  end

  desc "Install composer dependencies."
  task :composer do
    on roles(:web) do
      within release_path do
        execute :composer, "install --no-dev --quiet" # install dependencies
      end
    end
  end

  before :composer, :deploy_step_beforecomposer do
    on roles(:all) do
      print 'Installing composer components......'
    end
  end

  after :composer, :deploy_step_aftercomposer do
    on roles(:all) do
      puts '✔'.green
    end
  end

  before :artisan, :deploy_step_beforeartisan do
    on roles(:all) do
      print 'Making artisan executable......'
    end
  end

  after :artisan, :deploy_step_afterartisan do
    on roles(:all) do
      puts '✔'.green
    end
  end

  before :migratedb, :deploy_step_beforemigratedb do
    on roles(:all) do
      print 'Running database migrations......'
    end
  end

  after :migratedb, :deploy_step_aftermigratedb do
    on roles(:all) do
      puts '✔'.green
    end
  end

end
