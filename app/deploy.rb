set :application, 'kaunas2'
set :repo_url, 'https://github.com/nfqakademija/gokid.git'

set :deploy_to, '/home/gokid/'

set :branch, 'master'
set :scm, :archive

set :linked_files, fetch(:linked_files, []).push('app/config/parameters.yml')
set :linked_dirs, fetch(:linked_dirs, []).push('app/logs')

