# -*- mode: ruby -*-
# vi: set ft=ruby :

$HOSTNAME = "wash.it"

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "bento/debian-8.2"
  config.vm.hostname = $HOSTNAME

  config.vm.network "private_network", ip: "192.168.33.27"

  config.vm.synced_folder "./", "/var/www/washit", type: "nfs"

# Ansible
  config.vm.provision "ansible" do |ansible|
    ansible.sudo = true
    ansible.limit = "vagrant"
    ansible.inventory_path = "provisioning/hosts/vagrant"
    ansible.playbook = "../open-orchestra-provision/site.yml"
    ansible.verbose = "v"
  end
end
