<template>
    <div class="fancy-table">
        <div class="flex flex-row between mb-4">
            <div class="flex-1">
                <slot name="buttons"></slot>
            </div>
            <div class="flex-1 text-right flex flex-row justify-end items-center">
                <slot name="search"></slot>
            </div>
        </div>
        <div class="table-wrapper">
            <table class="table">
                <thead>
                <tr class="table-header">
                    <template v-for="h in header">
                        <slot :name="'header-'+h" v-bind:item="h">
                            <th class="text-left">{{ h }}</th>
                        </slot>
                    </template>
                </tr>
                </thead>
                <tbody v-if="data.length !== 0">
                <template v-for="(d,index) in data">
                    <tr class="table-body" :class="(index % 2)?'table-body-even':'table-body-odd'">
                        <template v-for="property in dataWith">
                            <slot :name="property" v-bind:row="d" v-bind:item="d[property]">
                                <td class="align-middle">{{ d[property] }}</td>
                            </slot>
                        </template>
                    </tr>
                    <tr class="table-body" :class="(index % 2)?'table-body-even':'table-body-odd'"
                        v-if="withAdditionalRow">
                        <td :colspan="(selectable)?header.length+1:header.length">
                            <slot name="additional-row" v-bind:row="d"></slot>
                        </td>
                    </tr>
                </template>
                </tbody>
                <tbody v-else>
                <tr>
                    <td class="text-center text-blue-500 font-bold bg-blue-200"
                        :colspan="(selectable)?header.length+1:header.length">
                        Nothing to show
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="flex flex-row justify-between items-center">
            <div>
                <slot name="stats" v-if="Object.keys(stats).length !== 0">
                    Showing {{ stats.to }} of {{ stats.total }} {{ dataName }}s
                </slot>
            </div>
            <div>
                <Pagination :links="pagination" v-if="pagination.length !== 0"/>
            </div>
        </div>

    </div>
</template>

<script>
import Pagination from "@/Shared/Table/Pagination";

export default {
    props: {
        value: {},
        dataName: {
            default: 'Item',
            type: String,
        },
        inProgress: {
            default: function () {
                return false;
            },
            type: Boolean,
        },
        withAdditionalRow: {
            default: false,
            type: Boolean,
        },
        selectable: {
            default: false,
            type: Boolean,
        },

        dataWith: {
            type: Array,
            default: function () {
                return [];
            },
        },
        stats: {
            type: Object,
            default: function () {
                return {};
            },
        },
        pagination: {
            type: Array,
            default: function () {
                return [];
            },
        },
        data: {
            type: Array,
            default: function () {
                return [];
            },
        },
        header: {
            type: Array,
            default: function () {
                return [];
            },
        },
    },
    name: "Table",
    data() {
        return {}
    },
    components: {Pagination}
}
</script>

<style scoped>

</style>
