
# Entrada per SSH:

```sh
ssh lanparty_181670
````

```
cat ~/.ssh/config
Host lanparty_181670
  Hostname 159.89.26.248
  User forge
  IdentityFile /home/sergi/.ssh/id_rsa
  Port 22
  StrictHostKeyChecking no
```

# Laravel Forge

https://forge.laravel.com/servers

Server:
- Id: 181670
- https://forge.laravel.com/servers/181670#/websites

```
$ df -h
Filesystem      Size  Used Avail Use% Mounted on
udev            487M     0  487M   0% /dev
tmpfs           100M  3.2M   97M   4% /run
/dev/vda1        25G  6.9G   18G  29% /
tmpfs           497M     0  497M   0% /dev/shm
tmpfs           5.0M     0  5.0M   0% /run/lock
tmpfs           497M     0  497M   0% /sys/fs/cgroup
/dev/vda15      105M  3.4M  102M   4% /boot/efi
tmpfs           100M     0  100M   0% /run/user/1000
```

# Digital Ocean

- Usuari: sergitur@iesebre.com
- Droplet: https://cloud.digitalocean.com/droplets/82315418/graphs?i=c56b69
-  sergitur / 1 GB Memory / 25 GB Disk / FRA1 - Ubuntu 16.04.3 x64 

# DNS

registre.lanparty.iesebre.com

# Backup Mysql


