set :deploy_config_path, File.expand_path('deploy/deploy.rb')
set :stage_config_path,  File.expand_path('deploy/stages')

# Load DSL and set up stages
require "capistrano/setup"

# Include default deployment tasks
require "capistrano/deploy"
require "capistrano/composer"

# Load the SCM plugin appropriate to your project:
require "capistrano/scm/git"
install_plugin Capistrano::SCM::Git


# Load custom tasks from `lib/capistrano/tasks` if you have any defined
Dir.glob("deploy/tasks/*.rake").each { |r| import r }
