/* eslint-disable @angular-eslint/use-lifecycle-interface */
import { Component, OnInit } from '@angular/core';
import { DataService } from '../services/data.service';

@Component({
  selector: 'app-home',
  templateUrl: 'home.page.html',
  styleUrls: ['home.page.scss'],
})
export class HomePage {
  tests: any;
  addcourse: any;
  updatecourse: any = {};
  isOpen = false;

  constructor(private data: DataService) {}

  ngOnInit(): void {
    console.log('hi');
    this.getRecords();
  }

  getRecords() {
    this.data.fetchData('tests', '').subscribe((response: any) => {
      console.log(response.payload);
      this.tests = response.payload;
    });
  }

  addCourse() {
    console.log(this.addcourse);
    const object = { name: this.addcourse, value: 'no' };
    this.data.fetchData('add_course', object).subscribe((response: any) => {
      console.log(response);
    });
    this.refreshPage();
  }

  updateCourse() {
    console.log(this.updatecourse);
    this.data
      .fetchData('update_course', this.updatecourse)
      .subscribe((response: any) => {
        console.log(response);
      });
    this.refreshPage();
  }

  deleteCourse(object: any) {
    console.log(object);
    this.data
      .fetchData('delete_course/' + object, '')
      .subscribe((response: any) => {
        console.log(response);
      });
    this.refreshPage();
  }

  openUpdate(object: any) {
    console.log(object);
    this.updatecourse = object;
    this.updatecourse.name = object.name;
    this.isOpen = true;
  }

  refreshPage() {
    window.location.reload();
  }
}
