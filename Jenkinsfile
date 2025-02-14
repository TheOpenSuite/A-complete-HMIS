pipeline {
    agent any
    environment {
        DOCKER_IMAGE = "theopensuite/hmis-app"
        DOCKER_BUILDKIT = '1'
    }
    stages {  
        stage('Test') {
            agent {
                docker {
                    image 'php:8.1-apache'
                    args '-v /var/run/docker.sock:/var/run/docker.sock --label ci-build=${env.BUILD_TAG}'
                }
            }
            steps {
                script {
                    // Build test image with labels
                    sh """
                        docker build -t ${DOCKER_IMAGE}:test-${env.BUILD_TAG} \\
                            --label ci-build=${env.BUILD_TAG} \\
                            --label stage=test \\
                            .
                    """
                    
                    // Create isolated network
                    sh "docker network create --label ci-build=${env.BUILD_TAG} test-net-${env.BUILD_TAG}"
                    
                    // Start test container
                    sh """
                        docker run -d \\
                            --name test-container-${env.BUILD_TAG} \\
                            --network test-net-${env.BUILD_TAG} \\
                            --label ci-build=${env.BUILD_TAG} \\
                            -p 8083:80 \\
                            ${DOCKER_IMAGE}:test-${env.BUILD_TAG}
                    """
                    
                    // Health check using disposable curl container
                    sh """
                        docker run --rm \\
                            --network test-net-${env.BUILD_TAG} \\
                            --label ci-build=${env.BUILD_TAG} \\
                            curlimages/curl \\
                            -s -o /dev/null -w "%{http_code}" \\
                            http://test-container-${env.BUILD_TAG}:80 \\
                            | grep -q 200
                    """
                }
            }
            post {
                always {
                    script {
                        // Remove test resources
                        sh "docker stop test-container-${env.BUILD_TAG} || true"
                        sh "docker rm test-container-${env.BUILD_TAG} || true"
                        sh "docker network rm test-net-${env.BUILD_TAG} || true"
                        sh "docker rmi ${DOCKER_IMAGE}:test-${env.BUILD_TAG} || true"
                    }
                }
            }
        }

        stage('Build & Push') {
            steps {
                script {
                    // Build production image
                    sh """
                        docker build -t ${DOCKER_IMAGE}:B${env.BUILD_NUMBER} \\
                            -t ${DOCKER_IMAGE}:latest \\
                            --label ci-build=${env.BUILD_TAG} \\
                            --label stage=production \\
                            .
                    """
                    
                    // Push images
                    withCredentials([string(credentialsId: 'docker-hmis-token', variable: 'DOCKER_TOKEN')]) {
                        sh """
                            echo \$DOCKER_TOKEN | docker login -u theopensuite --password-stdin
                            docker push ${DOCKER_IMAGE}:B${env.BUILD_NUMBER}
                            docker push ${DOCKER_IMAGE}:latest
                        """
                    }

                }
            }
        }
    }
    
    post {
        always {
            script {
                // Nuclear cleanup of all pipeline-created resources
                sh """
                    # Remove containers
                    docker rm -f \$(docker ps -aq --filter "label=ci-build=${env.BUILD_TAG}") 2>/dev/null || true
                    
                    # Remove images
                    docker rmi -f \$(docker images -q --filter "label=ci-build=${env.BUILD_TAG}") 2>/dev/null || true
                    
                    # Remove networks
                    docker network rm \$(docker network ls -q --filter "label=ci-build=${env.BUILD_TAG}") 2>/dev/null || true
                    
                    # Remove volumes
                    docker volume rm \$(docker volume ls -q --filter "label=ci-build=${env.BUILD_TAG}") 2>/dev/null || true
                    
                    # Cleanup all unused resources
                    docker system prune -af --filter "label=ci-build=${env.BUILD_TAG}"
                """
                
                // Final verification
                sh """
                    echo "=== Remaining Containers ==="
                    docker ps -a --filter "label=ci-build=${env.BUILD_TAG}"
                    echo "=== Remaining Images ==="
                    docker images --filter "label=ci-build=${env.BUILD_TAG}"
                """
            }
        }
    }
}