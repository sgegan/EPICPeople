set :stage_domain, "epicpeople.org"

# Set the deployment directory on the target hosts.
set :deploy_to, "/var/www/sites/virtual/epicpeople.org"

# The hostnames to deploy to.
role :web, "104.236.169.126"

# Specify one of the web servers to use for database backups or updates.
# This server should also be running Wordpress.
role :db, "104.236.169.126", :primary => true

# The path to wp-cli
set :wp, "cd #{current_path}/#{app_root} ; /usr/local/bin/wp"

set :httpd_group, "www-data"

# The username on the target system, if different from your local username
ssh_options[:user] = 'deploy'

before "deploy", "deploy:remote_changes"
