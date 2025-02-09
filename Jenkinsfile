pipeline {
  agent {
    docker {
      image 'php:8.2-apache'  // Use a PHP-enabled image for testing
      args '-v /var/run/docker.sock:/var/run/docker.sock'
    }
  }
  environment {
    DOCKERHUB_CREDENTIALS = credentials('dockerhub-creds')
    GIT_COMMIT_SHORT = sh(script: 'git rev-parse --short HEAD', returnStdout: true).trim()
  }
  stages {
    stage('Test') {
      steps {
        script {
          // Run the first PHP server on port 8080 in the background
          sh 'php -S localhost:8080 &'
          def server1_pid = sh(script: 'echo $!', returnStdout: true).trim()

          // Run the second PHP server on port 8000 in the background
          sh 'php -S localhost:8000 &'
          def server2_pid = sh(script: 'echo $!', returnStdout: true).trim()

          // Function to check server response and handle failure
          def checkServer = { port ->
            def status = sh(script: "curl -s -o /dev/null -w \"%{http_code}\" http://localhost:${port}", returnStdout: true).trim()
            return status == '200'
          }

          // Give servers a few seconds to start up (consider using a loop with retries)
          def retries = 5
          def success = false
          for (int i = 0; i < retries; i++) {
            if (checkServer(8080) && checkServer(8000)) {
              success = true
              break
            }
            sleep 2
          }

          if (!success) {
            error "Test failed: Servers on localhost:8080 and/or localhost:8000 did not respond with HTTP 200."
          } else {
            echo "Servers on localhost:8080 and localhost:8000 are running correctly."
          }

          // Cleanup the PHP servers after testing
          sh "kill ${server1_pid} ${server2_pid} || true"
        }
      }
    }
    stage('Build & Tag') {
      steps {
        script {
          // Build with both commit hash and latest tag
          docker.build("your-dockerhub/hmis-app:${env.GIT_COMMIT_SHORT}")
          docker.build("your-dockerhub/hmis-app:latest")
        }
      }
    }
    stage('Push') {
      steps {
        script {
          docker.withRegistry('https://registry.hub.docker.com', 'dockerhub-creds') {
            docker.image("your-dockerhub/hmis-app:${env.GIT_COMMIT_SHORT}").push()
            docker.image("your-dockerhub/hmis-app:latest").push()
          }
        }
      }
    }
  }
  post {
    always {
      // Cleanup unused Docker images
      sh 'docker system prune -f'
    }
  }
}
