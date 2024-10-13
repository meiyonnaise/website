#include <arpa/inet.h>
#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#include <unistd.h>
#include <pthread.h>
#include <ctype.h>

#define SERVER_IP "127.0.0.1"
#define MAX_BUFFER_SIZE 2048
#define MAX_NAME_LEN 50

pthread_mutex_t closeConnectionMutex;

struct sockaddr_in* initalise_server_address(char* portGiven);
void* thread_send(void* socket);
void* thread_recv(void* socket);
void remove_trailing_spaces(char* line);
void remove_preceeding_spaces(char* line);

int main(int argc, char* argv[]) {
    //second input is port (this is diff from assignment specs)
    if (argc < 3) {
        exit(1);
    }

    struct sockaddr_in servAddr;
    int* clientSocket = malloc(sizeof(int));
    int connectVal;
    char* name = argv[2];

    pthread_mutex_init(&closeConnectionMutex, NULL);
    pthread_t send_thread;
    pthread_t recv_thread;

    servAddr = *(initalise_server_address(argv[1]));
    *clientSocket = socket(AF_INET, SOCK_STREAM, 0);
    
    connectVal = connect(*clientSocket, (struct sockaddr*) &servAddr, sizeof(servAddr));
    if (connectVal == -1) {
        exit(1);
    }
    printf("name: %s\n",name);
    send(*clientSocket, name, 50, 0); //sending clients Name

    pthread_create(&send_thread, NULL, thread_send,  clientSocket);
    pthread_create(&recv_thread, NULL, thread_recv, clientSocket);

    pthread_join(send_thread, NULL);
    pthread_join(recv_thread, NULL);

}

void* thread_send(void* providedSocket) {
    int* socket = (int*) providedSocket;
    char sendMessage[MAX_BUFFER_SIZE];
    char buffer[MAX_BUFFER_SIZE + 30];

    while(1) {
        
        fgets(sendMessage, MAX_BUFFER_SIZE, stdin);

        pthread_mutex_lock(&closeConnectionMutex);
        if (*socket == -1) {
            printf("socket: %d\n", *socket);
                break;
        }
       pthread_mutex_unlock(&closeConnectionMutex);


        remove_trailing_spaces(sendMessage);
        remove_preceeding_spaces(sendMessage);

        sprintf(buffer, "%s", sendMessage);

        send(*socket, buffer, strlen(buffer), 0);

        bzero(sendMessage, MAX_BUFFER_SIZE);
        bzero(buffer, MAX_BUFFER_SIZE + 30);
    }
    return NULL;
}

void remove_trailing_spaces(char* line) {
    int lastIndex = strlen(line) - 1; // index of the last character 
    while (lastIndex > 0) {
        if (line[lastIndex] == ' ' || line[lastIndex] == '\n' || line[lastIndex] == '\t') {
            lastIndex--;
        } else { 
            // if it is a valid character then the new length of the string should be i.
            break;
        }
    }
    line[lastIndex + 1] = '\0'; 
}

void remove_preceeding_spaces(char* line) {
    int firstIndex = 0;
    while (line[firstIndex] != '\0') {
        if (line[firstIndex] == ' ' || line[firstIndex] == '\t') {
            firstIndex++;
        } else {
            break;
        }
    }
    line = line + firstIndex;
}


void* thread_recv(void* providedSocket) {
    int* socket = (int*) providedSocket;
    char recvBuffer[MAX_BUFFER_SIZE];
    int bytesReceived;
    while (1) {
        bytesReceived = recv(*socket, &recvBuffer, sizeof(recvBuffer), 0);
        // if server closes the connection, close connection from client side. 
        if (bytesReceived == 0 ) {
            pthread_mutex_lock(&closeConnectionMutex);
            close(*socket);
            *socket = -1;
            pthread_mutex_unlock(&closeConnectionMutex);
            break;
        }
        printf("%s", recvBuffer);
        fflush(stdout);
        bzero(recvBuffer, MAX_BUFFER_SIZE);
    }
    return NULL;
}

void* thread_command(void* command) {
    return NULL;
}

struct sockaddr_in* initalise_server_address(char* portGiven) {
    struct sockaddr_in* servAddr = malloc(sizeof(servAddr));
    int serverIp;
    unsigned short port;

    serverIp = inet_addr(SERVER_IP);
    port = (unsigned short) atoi(portGiven);

    servAddr->sin_family = AF_INET;
    servAddr->sin_port = htons(port);
    servAddr->sin_addr.s_addr = serverIp;

    return servAddr;
}