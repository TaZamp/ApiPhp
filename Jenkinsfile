pipeline {
  agent {
    label "docker-agent"
  }
  stages {
    stage ('Run Docker Compose') {
      steps {
        script {
          if (isUnix()) {
            sh 'docker-compose up -d'
          } else {
            bat 'docker-compose up -d'
          }
        }
      }
    }
  }
}
