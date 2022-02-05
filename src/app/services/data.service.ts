import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root',
})
export class DataService {
  baseURL: any = 'http://localhost/app-sample/api/';

  constructor(private http: HttpClient) {}

  public fetchData(endpoint: any, results: any) {
    return this.http.post<any>(this.baseURL + endpoint, JSON.stringify(results));
  }
}
