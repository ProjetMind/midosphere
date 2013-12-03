set :application, "midosphere"
set :domain,      "midosphere.com"
set :deploy_to,   "/var/www/midosphere"
#set :app_path,    "app"
#set :web_path,    "web"
set :user, "root"

set :shared_files,      ["app/config/parameters.yml"]
set :shared_children,     [app_path + "/logs", web_path + "/uploads", "vendor"]
set :use_composer, true
set :update_vendors, true
set :dump_assetic_assets, false
 
#set :repository,  "https://github.com/ProjetMind/midosphere.git"
set :repository,  "/Users/nsi/Sites/midosphere"
set :scm,         :git
set :deploy_via, :rsync_with_remote_cache
#set   :branch,        "prod"
# Or: `accurev`, `bzr`, `cvs`, `darcs`, `subversion`, `mercurial`, `perforce`, or `none`

set :model_manager, "doctrine"
# Or: `propel`

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain, :primary => true       # This may be the same as your `Web` server

set  :keep_releases,  3

# Be more verbose by uncommenting the following line
logger.level = Logger::MAX_LEVEL
