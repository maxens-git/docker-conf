sudo docker stop portainer
sudo docker rm portainer
sudo docker pull portainer/portainer-ee:latest
sudo docker run -d -p 8000:8000 -p 9443:9443 --network=nginx-proxy-manager_default --name=portainer --restart=always -v /var/run/docker.sock:/var/run/docker.sock -v portainer_data:/data portainer/portainer-ee:latest
