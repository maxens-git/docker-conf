docker stop portainer
docker rm portainer
docker pull portainer/portainer-ee:latest
docker run -d -p 8000:8000 -p 9443:9443 --net=nginx-proxy-manager_default --label=diun.enable=true --name=portainer --restart=always -v /var/run/docker.sock:/var/run/docker.sock -v portainer_data:/data portainer/portainer-ee:latest