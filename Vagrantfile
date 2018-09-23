# -*- mode: ruby -*-
# vi: set ft=ruby :

VAGRANTFILE_API_VERSION = "2"

Vagrant.require_version ">= 1.6.5"

Vagrant.configure("2") do |config|
  scriptsDirectory = File.dirname(__FILE__) + '/.vagrant-scripts'

  config.vm.box = "ubuntu/xenial64"
  config.vm.box_check_update = true

  config.ssh.forward_agent = true

  config.vm.synced_folder ".", "/home/vagrant/pipeline"

  config.vm.hostname = "pipeline.vagrant"
  config.vm.define "pipeline"

  config.vm.provider "virtualbox" do |vm|
    vm.memory = 1024
    vm.cpus = 1
  end

  # Configure A Few VirtualBox Settings
  config.vm.provider "virtualbox" do |vb|
    vb.name = "pipeline"
  end

  config.vm.provision "shell" do |s|
    s.name = "Installing zsh"
    s.path = scriptsDirectory + "/install-zsh.sh"
  end

  config.vm.provision "shell" do |s|
    s.name = "Installing php"
    s.path = scriptsDirectory + "/install-php.sh"
  end

  # Create SSH directory
  config.vm.provision "shell" do |s|
    s.name = "Create SSH folder"
    s.inline = "test -d '/home/vagrant/.ssh' && echo 'SSH directory exists' || mkdir /home/vagrant/.ssh"
  end

  # Copy SSH files over
  config.vm.provision "file", source: "~/.ssh/id_rsa", destination: "/home/vagrant/.ssh/id_rsa"
  config.vm.provision "file", source: "~/.ssh/id_rsa.pub", destination: "/home/vagrant/.ssh/id_rsa.pub"
  config.vm.provision "file", source: "~/.ssh/known_hosts", destination: "/home/vagrant/.ssh/known_hosts"

  config.vm.provision "shell" do |s|
    s.name = "Setting SSH permissions"
    s.privileged = false
    s.inline = "chmod 0600 ~/.ssh/{id_rsa,id_rsa.pub,known_hosts}"
  end

  # Download .dotfiles
  config.vm.provision "shell" do |s|
    s.name = "Download .dotfiles"
    s.privileged = false
    s.inline = "test -d '/home/vagrant/.dotfiles' && echo '.dotfiles exists' || git clone git@github.com:JayyWalker/.dotfiles.git /home/vagrant/.dotfiles"
  end
end
