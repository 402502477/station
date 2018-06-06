@extends('layouts.layout')
@section('title','用户列表')
@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">用户管理</h3>
        </div>
        <div class="panel-body">
            <div class="handler">
                <form action="" class="form-inline">
                    <div class="form-group">
                        <select class="form-control">
                            <option value="cheese">Cheese</option>
                            <option value="tomatoes">Tomatoes</option>
                            <option value="mozarella">Mozzarella</option>
                            <option value="mushrooms">Mushrooms</option>
                            <option value="pepperoni">Pepperoni</option>
                            <option value="onions">Onions</option>
                        </select>
                    </div>
                    <button class="btn btn-primary" type="button">123</button>
                    <button class="btn btn-danger">123</button>
                </form>


            </div>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>
                        <label class="fancy-checkbox">
                            <input type="checkbox">
                            <span></span>
                        </label>
                    </th>
                    <th>序号</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Username</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>Steve</td>
                    <td>Jobs</td>
                    <td>@steve</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Simon</td>
                    <td>Philips</td>
                    <td>@simon</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Jane</td>
                    <td>Doe</td>
                    <td>@jane</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@stop
@section('footer')
@stop