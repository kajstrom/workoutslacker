# -*- mode: ruby -*-
# vi: set ft=ruby :

# All Vagrant configuration is done below. The "2" in Vagrant.configure
# configures the configuration version (we support older styles for
# backwards compatibility). Please don't change it unless you know what
# you're doing.
Vagrant.configure(2) do |config|
  # The most common configuration options are documented and commented below.
  # For a complete reference, please see the online documentation at
  # https://docs.vagrantup.com.

  # Every Vagrant development environment requires a box. You can search for
  # boxes at https://atlas.hashicorp.com/search.
  config.vm.box = "ubuntu/trusty64"

  # Disable automatic box update checking. If you disable this, then
  # boxes will only be checked for updates when the user runs
  # `vagrant box outdated`. This is not recommended.
  # config.vm.box_check_update = false

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine. In the example below,
  # accessing "localhost:8080" will access port 80 on the guest machine.
  config.vm.network "forwarded_port", guest: 80, host: 3000

  # Create a private network, which allows host-only access to the machine
  # using a specific IP.
  # config.vm.network "private_network", ip: "192.168.33.10"

  # Create a public network, which generally matched to bridged network.
  # Bridged networks make the machine appear as another physical device on
  # your network.
  # config.vm.network "public_network"

  # Share an additional folder to the guest VM. The first argument is
  # the path on the host to the actual folder. The second argument is
  # the path on the guest to mount the folder. And the optional third
  # argument is a set of non-required options.
  # config.vm.synced_folder "../data", "/vagrant_data"

  # Provider-specific configuration so you can fine-tune various
  # backing providers for Vagrant. These expose provider-specific options.
  # Example for VirtualBox:
  #
  # config.vm.provider "virtualbox" do |vb|
  #   # Display the VirtualBox GUI when booting the machine
  #   vb.gui = true
  #
  #   # Customize the amount of memory on the VM:
  #   vb.memory = "1024"
  # end
  #
  # View the documentation for the provider you are using for more
  # information on available options.

  # Define a Vagrant Push strategy for pushing to Atlas. Other push strategies
  # such as FTP and Heroku are also available. See the documentation at
  # https://docs.vagrantup.com/v2/push/atlas.html for more information.
  # config.push.define "atlas" do |push|
  #   push.app = "YOUR_ATLAS_USERNAME/YOUR_APPLICATION_NAME"
  # end

  # Enable provisioning with a shell script. Additional provisioners such as
  # Puppet, Chef, Ansible, Salt, and Docker are also available. Please see the
  # documentation for more information about their specific syntax and use.
	config.vm.provision "shell", inline: <<-SHELL
	 sudo add-apt-repository ppa:ondrej/php -y
     sudo apt-get update
     sudo apt-get install php7.0 -y
	 sudo apt-get install php7.0-mbstring -y
	 sudo apt-get install php7.0-zip -y
	 sudo apt-get install php7.0-dom -y 
	 sudo apt-get install php7.0-fpm -y
	 sudo apt-get install php7.0-mysql -y
	 sudo apt-get install php7.0-curl -y
	 sudo apt-get install nginx -y
	 sudo cp /vagrant/config/nginx_sites-enabled_default /etc/nginx/sites-enabled/default
	 sudo cp /vagrant/config/php.ini /etc/php/7.0/fpm/php.ini
	 sudo service php7.0-fpm restart
	 sudo service nginx restart
	 php -r "readfile('https://getcomposer.org/installer');" > composer-setup.php
	 php -r "if (hash('SHA384', file_get_contents('composer-setup.php')) === '41e71d86b40f28e771d4bb662b997f79625196afcca95a5abf44391188c695c6c1456e16154c75a211d238cc3bc5cb47') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
	 php composer-setup.php
	 php -r "unlink('composer-setup.php');"
	 sudo mv composer.phar /usr/local/bin/composer
	 sudo /bin/dd if=/dev/zero of=/var/swap.1 bs=1M count=1024
	 sudo /sbin/mkswap /var/swap.1
	 sudo /sbin/swapon /var/swap.1
	 echo mysql-server mysql-server/root_password password strangehat | sudo debconf-set-selections
	 echo mysql-server mysql-server/root_password_again password strangehat | sudo debconf-set-selections
	 sudo apt-get install mysql-server -y 
	 sudo apt-get install mysql-client -y
	 mysql --user=root --password=root -e 'CREATE DATABASE workout;'
	SHELL
end
