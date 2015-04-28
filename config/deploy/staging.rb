set :stage_domain, "epicpeople-staging.metaltoad.com"

# Set the deployment directory on the target hosts.
set :deploy_to, "/var/www/sites/virtual/epicpeople-staging.metaltoad.com"


# The hostnames to deploy to.
role :web, "#{application}-#{stage}.metaltoad.com"

# Specify one of the web servers to use for database backups or updates.
# This server should also be running Wordpress.
role :db, "#{application}-#{stage}.metaltoad.com", :primary => true

# The path to wp-cli
set :wp, "cd #{current_path}/#{app_root} ; /usr/local/bin/wp"

# The username on the target system, if different from your local username
ssh_options[:user] = 'deploy'

before "deploy", "deploy:remote_changes"
