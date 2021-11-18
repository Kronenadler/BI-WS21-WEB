import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Friend } from '../models/Friend';
import { Message } from '../models/Message';
import { Profile } from '../models/Profile';
import { User } from '../models/User';
import { ContextService } from './context.service';

@Injectable({
    providedIn: 'root'
})
export class BackendService {
    private baseURL: string = 'https://online-lectures-cs.thi.de/chat/';
    private serverId: string = '<ihre Server ID!>';
    private restServerURL: string = this.baseURL + this.serverId + '/';
    private headers: any; // header for token

    public constructor(private httpClient: HttpClient, private context: ContextService) { 
    }

    public login(username: string, password: string): Promise<boolean> {
        const body = { "username": username, "password": password };

        return this.httpClient.post(this.restServerURL + 'login', body)
        .toPromise()
        .then(token => {
            this.setUser(username, token);
            return Promise.resolve(true);
        })
        .catch(() => Promise.resolve(false));
    }

    public register(username: string, password: string): Promise<boolean> {
        const body = {
            "username": username, 
            "password": password 
        };
        return this.httpClient.post(this.restServerURL + 'register', body)
        .toPromise()
        .then(token => {
            this.setUser(username, token);
            return Promise.resolve(true);
        })
        .catch(() => Promise.resolve(false));
    }

    public userExists(username: string): Promise<boolean> {
        return this.httpClient.get(this.restServerURL + 'user/' + username)
        .toPromise()
        .then(() => Promise.resolve(true))
        .catch(() => Promise.resolve(false));
    }

    public loadCurrentUser(): Promise<User | null> {
        return this.loadUser(this.context.loggedInUsername);
    }

    public loadUser(username: string): Promise<User | null> {
        return this.httpClient.get(
            this.restServerURL + 'user/' + username, 
            this.headers)
        .toPromise()
        .then((buffer: any) => {
            const user = buffer as User;

            return Promise.resolve(user);
        })
        .catch(() => Promise.resolve(null));
    }

    public loadFriends(): Promise<Array<Friend>> {
        return this.httpClient.get(
            this.restServerURL + 'friend', 
            this.headers)
        .toPromise()
        .then((buffer: any) => {
            const friends = buffer as Array<Friend>;

            return Promise.resolve(friends);
        })
        .catch(() => {
            alert('Error loading friends!');
            return Promise.resolve([])
        });
    }

    public saveCurrentUserProfile(profile: Profile): Promise<boolean> {
        return this.httpClient.put(this.restServerURL + 'user', profile, this.headers)
        .toPromise()
        .then(token => {
            return Promise.resolve(true);
        })
        .catch(() => Promise.resolve(false));
    }

    public friendRequest(username: string): Promise<boolean> {
        return this.httpClient.post(
            this.restServerURL + 'friend', 
            { "username": username },
            this.headers)
        .toPromise()
        .then(() => {
            return Promise.resolve(true);
        })
        .catch(() => Promise.resolve(false));
    }

    public acceptFriendRequest(username: string): Promise<boolean> {
        return this.acceptOrDismissFriendRequest(username, 'accepted');
    }

    public dismissFriendRequest(username: string): Promise<boolean> {
        return this.acceptOrDismissFriendRequest(username, 'dismissed');
    }

    private acceptOrDismissFriendRequest(username: string, status: string): Promise<boolean> {
        return this.httpClient.put(
            this.restServerURL + 'friend/' + username,
            { "status": status },
            this.headers)
        .toPromise()
        .then(() => {
            return Promise.resolve(true);
        })
        .catch(() => Promise.resolve(false));
    }

    public removeFriend(username: string): Promise<boolean> {
        return this.httpClient.delete(
            this.restServerURL + 'friend/' + username, 
            this.headers)
        .toPromise()
        .then(() => {
            return Promise.resolve(true);
        })
        .catch(() => Promise.resolve(false));
    }

    public unreadMessageCounts(): Promise<Map<string, number>> {
        return this.httpClient.get(
            this.restServerURL + 'unread', 
            this.headers)
        .toPromise()
        .then((result: any) => {
            const map = new Map<string, number>();

            for (let key of Object.keys(result)) {
                map.set(key, result[key]);
            }
            return Promise.resolve(map);
        })
        .catch(() => Promise.resolve(new Map<string, number>()));
    }

    public listMessages(otherUser: string): Promise<Array<Message>> {
        return this.httpClient.get(
            this.restServerURL + 'message/' + otherUser, 
            this.headers)
        .toPromise()
        .then((result: any) => {
            const messages = result as Array<Message>;
            return Promise.resolve(messages);
        })
        .catch(() => Promise.resolve([]));
    }

    public sendMessage(receiverUsername: string, msg: string): Promise<boolean> {
        const body = { "message": msg, "to": receiverUsername };

        return this.httpClient.post(this.restServerURL + 'message', body, this.headers)
        .toPromise()
        .then(() => Promise.resolve(true))
        .catch(() => Promise.resolve(false));
    }

    /**
     * Store username and token (from login call) for further reference.
     * The token is embedded in a http header value.
     * @param username name of logged in user
     * @param token security token for subsequent calls
     */
    private setUser(username: string, token: any): void {
        this.context.loggedInUsername = username;
        const headers = new HttpHeaders()
            .set('content-type', 'application/json')
            .set('Authorization', 'Bearer ' + token.token);
        this.headers = { 'headers': headers };
        console.log(`user ${username} - token: ${JSON.stringify(token)}`);
    }
}
